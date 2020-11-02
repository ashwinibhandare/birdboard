class Form
{
    constructor(data){
        this.originalData = data;
        for (let field in data) {
            this[field] = data[field]
        }
        this.errors = new Errors()
    }

    data() {
        let data = {}; // clone data
        for (let property in this.originalData) {
            data[property] = this[property]
        }

        return data;
    }

    reset() {
        for (let field in originalData) {
            this.field = '';
        }
    }

    post(url) {
        return this.submit('POST', url)
    }

    delete(url) {
        return this.submit('DELETE', url)
    }

    submit(requestType, url) {
        return new Promise((resolve, reject)=> {
            axios.post(url, this.data())
                .then(responce => {
                    this.onSuccess(responce.data);
                    resolve(responce.data)
                })
                .catch(error => {
                    this.onFail(error.response.data.errors)
                    reject(error.response.data.errors)
                })

            //catch(error => this.errors.record(error.response.data.errors));
        });
    }
    onFail(errors) {
        this.errors.record(errors)
    }
    onSuccess(data) {
        this.errors.clear();
    }
}
