import './App.css';
import Nav from "react-bootstrap/Nav";
import Navbar from "react-bootstrap/Navbar";
import 'bootstrap/dist/css/bootstrap.css';
import Container from "react-bootstrap/Container";
import React from "react";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import { BrowserRouter as Router, Switch, Route, Link } from "react-router-dom";
import CreateStudents from "./Components/create-students";
import ShowSecondHighestSalary from "./Components/show-secondHighestSalary";
import ShowStudentsList from "./Components/show-studentsList";

function App() {
  return (<Router>
    <div className="App">
      <header>
        <Navbar bg="success" variant="success">
          <Container>

            <Navbar.Brand>
              <Link to={"/"} className="nav-link">
                Create Students
              </Link>
            </Navbar.Brand>

            <Nav className="justify-content-end">
              <Nav>
                <Link to={"/students"} className="nav-link">
                  Show Students
                </Link>
              </Nav>
            </Nav>

            <Nav className="justify-content-end">
              <Nav>
                <Link to={"/students/secondhighestpocketmoney"} className="nav-link">
                  Show Secondhighest Salary
                </Link>
              </Nav>
            </Nav>

          </Container>
        </Navbar>
      </header>

      <Container>
        <Row>
          <Col md={12}>
            <div className="wrapper">
              <Switch>
                <Route exact path='/' component={CreateStudents} />
                <Route path="/students/secondhighestpocketmoney" component={ShowSecondHighestSalary} />
                <Route path="/students" component={ShowStudentsList} />
              </Switch>
            </div>
          </Col>
        </Row>
      </Container>
    </div>
  </Router>);
}

export default App;
