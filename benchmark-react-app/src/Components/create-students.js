import React, {useState} from "react";
import axios from "axios";

function CreateStudents() {
    const [state, setState] = useState({
        error: {},
        first_name: '',
        last_name: '',
        email: '',
        pocket_money: '',
        password: '',
        age: '',
        city: '',
        state: '',
        zip: '',
        country: '',
    });

    /**
     * Handle state and errors on change of input element
     *
     * @param evt
     */
    function handleChange(evt) {
        setState({
            ...state,
            [evt.target.name]: evt.target.value
        });
        handleError(evt);
    }

    /**
     * Onchange of input element remove error
     *
     * @param evt
     */
    function handleError(evt) {
        if (state.error) {
            if (evt.target.name in state.error) {
                state.error[evt.target.name][0] = ''
            }
        }
    }

    /**
     * On fail of submit request record error and existing state values
     *
     * @param error
     */
    function onFail(error) {
        setState({
            error: error,
            first_name: state.first_name,
            last_name: state.last_name,
            email: state.email,
            pocket_money: state.pocket_money,
            password: state.password,
            age: state.age,
            city: state.city,
            state: state.state,
            zip: state.zip,
            country: state.country,
        });
    }

    /**
     * On success of submit request show sucess message and clear state values
     */
    function onSuccess() {
        const userSuccess = document.getElementById("user-success");
        userSuccess.removeAttribute('hidden');
        setTimeout(function () {
            userSuccess.setAttribute('hidden', true);
        }, 3000);
        document.getElementById("student-form").reset();
        setState({
            error: {},
            first_name: '',
            last_name: '',
            email: '',
            pocket_money: '',
            password: '',
            age: '',
            city: '',
            state: '',
            zip: '',
            country: ''
        });
    }

    /**
     * Handle submit request
     *
     * @param e
     */
    function onSubmit(e) {
        e.preventDefault()
        delete state.error;
        const studentData = {
            method: 'POST',
            headers: {'content-type': 'application/json'},
            data: JSON.stringify(state),
            url: 'http://127.0.0.1:8001/api/students'
        };
        axios(studentData).then(res => {
            onSuccess();
        }).catch(errors => {
            onFail(errors.response.data.errors);
        })
    }

    return (
        <form className="form" onSubmit={onSubmit} autoComplete="off" id="student-form">
            <div className="form-group row">
                <label className="col-lg-3 col-form-label form-control-label">First name</label>
                <div className="col-lg-9">
                    <input className="form-control" value={state.first_name} onChange={handleChange} type="text"
                           name="first_name"/>
                    <span style={{color: 'red'}}>{state.error ? state.error.first_name : ''}</span>
                </div>
            </div>

            <div className="form-group row">
                <label className="col-lg-3 col-form-label form-control-label">Last name</label>
                <div className="col-lg-9">
                    <input className="form-control" type="text" onChange={handleChange} value={state.last_name}
                           name="last_name"/>
                    <span style={{color: 'red'}}>{state.error ? state.error.last_name : ''}</span>
                </div>
            </div>

            <div className="form-group row">
                <label className="col-lg-3 col-form-label form-control-label">Email</label>
                <div className="col-lg-9">
                    <input className="form-control" type="email" onChange={handleChange} value={state.email}
                           name="email"/>
                    <span style={{color: 'red'}}>
                        {state.error ? state.error.email : ''}
                        </span>
                </div>
            </div>

            <div className="form-group row">
                <label className="col-lg-3 col-form-label form-control-label">Pocket
                    Money</label>
                <div className="col-lg-9">
                    <input className="form-control" type="text" onChange={handleChange} value={state.pocket_money}
                           name="pocket_money"/>
                    <span style={{color: 'red'}}>
                        {state.error ? state.error.pocket_money : ''}
                    </span>
                </div>
            </div>

            <div className="form-group row">
                <label className="col-lg-3 col-form-label form-control-label">Password</label>
                <div className="col-lg-9">
                    <input className="form-control" type="text" onChange={handleChange} value={state.password}
                           name="password"/>
                    <span style={{color: 'red'}}>
                        {state.error ? state.error.password : ''}
                    </span>
                </div>
            </div>

            <div className="form-group row">
                <label className="col-lg-3 col-form-label form-control-label">Age</label>
                <div className="col-lg-9">
                    <input className="form-control" type="text" onChange={handleChange} value={state.age} name="age"/>
                    <span style={{color: 'red'}}>
                        {state.error ? state.error.age : ''}
                    </span>
                </div>
            </div>

            <div className="form-group row">
                <label className="col-lg-3 col-form-label form-control-label">City</label>
                <div className="col-lg-9">
                    <input className="form-control" type="text" onChange={handleChange} value={state.city} name="city"/>
                    <span style={{color: 'red'}}>
                        {state.error ? state.error.city : ''}
                    </span>
                </div>
            </div>

            <div className="form-group row">
                <label className="col-lg-3 col-form-label form-control-label">State</label>
                <div className="col-lg-9">
                    <input className="form-control" type="text" onChange={handleChange} value={state.state}
                           name="state"/>
                    <span style={{color: 'red'}}>
                        {state.error ? state.error.state : ''}
                        </span>
                </div>
            </div>

            <div className="form-group row">
                <label className="col-lg-3 col-form-label form-control-label">Zip</label>
                <div className="col-lg-9">
                    <input className="form-control" type="text" onChange={handleChange} value={state.zip} name="zip"/>
                    <span style={{color: 'red'}}>
                        {state.error ? state.error.zip : ''}
                    </span>
                </div>
            </div>
            <div className="form-group row">
                <label className="col-lg-3 col-form-label form-control-label">Country</label>
                <div className="col-lg-9">
                    <input className="form-control" type="text" onChange={handleChange} value={state.country}
                           name="country"/>
                    <span style={{color: 'red'}}>
                        {state.error ? state.error.country : ''}
                        </span>
                </div>
            </div>
            <div className="form-group row">
                <label className="col-lg-3 col-form-label form-control-label"></label>
                <div className="col-lg-9">
                    <input type="reset" className="btn btn-secondary" value="Cancel"/>
                    <input type="submit" className="btn btn-primary" value="Save"/>
                </div>
            </div>
            <div hidden className="alert alert-success" id="user-success" role="alert">
                Added Successfully
            </div>
        </form>
    );
}

export default CreateStudents;
