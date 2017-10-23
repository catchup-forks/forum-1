<?php

namespace App\Console\Commands;

use App\Club;
use App\Race;
use App\Result;
use App\Runner;
use App\Split;
use App\SplitResult;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class GetResult extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'result:get {page=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get results from competition';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $page = ($this->argument('page')) ? (int)$this->argument('page') : 0;
        $url = 'http://results.neptron.se/webapi/lidingolor2017/results?page='.$page.'&pageSize=250&raceId=99&sortOrder=Place';

        $client = new Client();
        $results = json_decode($client->get($url)->getBody()->getContents());

        $lastPage = false;
        if (count($results->results) < 200) $lastPage = true;

        foreach ($results->results as $raceResult) {

            $raceName = $raceResult->race . ' ' . date('Y');

            $race = $this->getRace($raceName);
            $runner = $this->getRunner($raceResult);
            $club = $this->getClub($raceResult->club);
            $result = $this->getResult($runner, $race, $raceResult, $club);

            foreach ($raceResult->legSplits as $legSplit) {
                if (!$split = Split::where('name', $legSplit->splitName)->where('race_id', $race->id)->first()) {
                    $split = new Split();
                    $split->name = $legSplit->splitName;
                    $split->race_id = $race->id;
                    $split->save();
                }
                $this->setSplit($split, $legSplit, $result);
            }
        }

        if (!$lastPage) {
            Artisan::call('result:get', [
                'page' => $page+1
            ]);
        }
    }

    /**
     * @param $result
     * @return Runner
     */
    private function getRunner($result): Runner
    {
        if (!$runner = Runner::where('name', $result->firstName . ' ' . $result->lastName)
            ->where('birthyear', $result->yoB)
            ->where('nationality', $result->flag)
            ->first()
        ) {
            $runner = new Runner();
            $runner->name = $result->firstName . ' ' . $result->lastName;
            $runner->birthyear = $result->yoB;
            $runner->nationality = $result->flag;
            $runner->city = $result->city;
            $runner->gender = $result->gender;
            $runner->save();
        }

        return $runner;
    }

    /**
     * @param $raceName
     * @return Race
     */
    private function getRace($raceName): Race
    {
        if (!$race = Race::where('name', $raceName)->first()) {
            $race = new Race();
            $race->name = $raceName;
            $race->save();
        }

        return $race;
    }

    /**
     * @param $clubName
     * @return Club
     */
    private function getClub($clubName): Club
    {
        if (!$club = Club::where('name', $clubName)->first()) {
            $club = new Club();
            $club->name = $clubName;
            $club->save();
        }

        return $club;
    }

    /**
     * @param $runner
     * @param $race
     * @param $raceResult
     * @param $club
     * @return Result
     */
    private function getResult($runner, $race, $raceResult, $club): Result
    {
        if (!$result = Result::where('runner_id', $runner->id)->where('race_id', $race->id)->first()) {

            $totalTime = 0;
            $totalTime = $this->convertTimeStringToInteger($raceResult->totalTime, $totalTime);

            $result = new Result();
            $result->start_number = $raceResult->startNo;
            $result->runner_id = $runner->id;
            $result->club_id = $club->id;
            $result->race_id = $race->id;
            $result->category = $raceResult->category;
            $result->total_time = $totalTime;
            $result->save();
        }

        return $result;
    }

    /**
     * @param $legSplit
     * @param $result
     */
    private function setSplit($split, $legSplit, $result)
    {

        if (!$splitResult = SplitResult::where('split_id', $split->id)
            ->where('result_id', $result->id)
            ->first()
        ) {
            $time = 0;
            $time = $this->convertTimeStringToInteger($legSplit->time, $time);

            $splitTime = 0;
            $splitTime = $this->convertTimeStringToInteger($legSplit->split, $splitTime);

            $splitResult = new SplitResult();
            $splitResult->split_id = $split->id;
            $splitResult->result_id = $result->id;
            $splitResult->total_time = $time;
            $splitResult->split_time = $splitTime;
            $splitResult->save();
        }
    }

    /**
     * @param $timeSplitSplit
     * @param $splitTime
     * @return int
     */
    private function convertTimeStringToInteger($timeSplitSplit, $splitTime)
    {
        $exploded = explode(':', $timeSplitSplit);

        Log::info($timeSplitSplit);

        $exploded = array_reverse($exploded);
        for ($i = 0; $i < count($exploded); $i++) {
            // om det är sekunder
            if ($i+1 == 1) $splitTime += (int)$exploded[$i];

            // om det är minuter
            if ($i+1 == 2) $splitTime += (int)$exploded[$i] * 60;

            // om det är timmar
            if ($i+1 == 3) $splitTime += (int)$exploded[$i] * 60 * 60;
        }


        return $splitTime;
    }
}
