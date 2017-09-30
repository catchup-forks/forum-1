import Errors from './errors';

class Form {
    constructor(data, reset) {
        this.originalData = data;

        for (let field in data) {
            this[field] = data[field];
        }

        this.errors = new Errors();
        this.success = false;

        if (typeof reset == undefined) {
            this.reset = true;
        } else {
            this.reset = reset;
        }
    }

    onReset() {


        if (this.reset !== false) {

            for (let field in this.originalData) {
                console.log(this[field]);

                this[field] = '';
            }
        }
    }

    data() {
        let data = Object.assign({}, this)

        delete data.originalData;
        delete data.errors;

        return data
    }

    submit(method, route, reset) {

        return new Promise((resolve, reject) => {
            axios[method](route, this.data())
                .then(response => {
                    this.onSuccess(response.data)
                    resolve(response.data)
                })
                .catch(error => {
                    if (error.response) {
                        this.onFail(error.response.data);
                        resolve(error.response.data)
                    }
                });
        });
    }

    onSuccess(data) {
        this.success = true;
        this.onReset();
    }

    onFail(errors) {
        if (errors) {
            this.success = false;
            this.errors.record(errors)
        }
    }

}

export default Form;