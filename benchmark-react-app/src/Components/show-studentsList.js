import React from 'react'
import {useState, useEffect} from 'react'
import axios from "axios";

function ShowStudentsList() {
    const [data, setData] = useState([]);

    /**
     * Call api to get data of students who have prime number id
     */
    useEffect(() => {
        const GetData = async () => {
            const result = await axios('http://127.0.0.1:8000/api/students');
            setData(Object.values(result.data.data));
        }
        GetData();
    }, []);


    return (
        <table className="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Pocket Money</th>
            </tr>
            </thead>
            <tbody>
            {
                data.data != [] ?
                    data.map((item, id) => {
                        return <tr key={item.id}>
                            <td>{item.id}</td>
                            <td>{item.first_name}</td>
                            <td>{item.last_name}</td>
                            <td>{item.pocket_money}</td>
                        </tr>
                    }) : <tr>
                        <td colSpan={4}>Data is not available</td>
                    </tr>}
            </tbody>
        </table>
    );
}

export default ShowStudentsList;