class Errors {
    constructor() {
        this.errors = {}
    }

    any() {
        return Object.keys(this.errors).length > 0
    }

    has(field) {
        return this.errors[field]
    }

    get(field) {
        if (this.errors[field]) {
            return this.errors[field][0]
        }
    }

    clear(field) {
        delete this.errors[field]
    }

    record(errors) {
        this.errors = errors
    }
}

export default Errors;