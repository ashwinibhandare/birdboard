class Errors {

    constructor(){
        this.errors = {};
    }

    record(errors){
        this.errors = errors;
    }

    get(field){
        if (this.errors[field]) {
            return this.errors[field][0];
        }
    }

    clear(field) {
        if (field) delete this.errors[field]

        this.errors = {};
    }
    has(field) {
        //if error contains property
        return this.errors.hasOwnProperty(field);
    }
    any() {
        return Object.keys(this.errors).length > 0;
    }
}
