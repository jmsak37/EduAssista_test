const express = require('express');
const bodyParser = require('body-parser');
const mysql = require('mysql');

const app = express();
const port = 3000;

app.use(bodyParser.json());

// Create MySQL connection
const connection = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: 'yourpassword',
    database: 'EduAssistaDB'
});

connection.connect();

// Endpoint to save unknown responses
app.post('/saveUnknownResponse', (req, res) => {
    const userInput = req.body.userInput;
    connection.query('INSERT INTO UnknownResponses (UserInput) VALUES (?)', [userInput], (err) => {
        if (err) throw err;
        res.sendStatus(200);
    });
});

// Endpoint to get unanswered questions
app.get('/getUnansweredQuestions', (req, res) => {
    connection.query('SELECT QuestionText FROM Questions LEFT JOIN Responses ON Questions.QuestionID = Responses.QuestionID WHERE Responses.ResponseText IS NULL', (err, results) => {
        if (err) throw err;
        res.json({ questions: results.map(row => row.QuestionText) });
    });
});

// Endpoint to save question-response pairs
app.post('/saveQuestionResponse', (req, res) => {
    const { question, response } = req.body;
    connection.query('INSERT INTO Questions (QuestionText) VALUES (?)', [question], (err, results) => {
        if (err) throw err;
        const questionID = results.insertId;
        connection.query('INSERT INTO Responses (QuestionID, ResponseText) VALUES (?, ?)', [questionID, response], (err) => {
            if (err) throw err;
            res.sendStatus(200);
        });
    });
});

app.listen(port, () => {
    console.log(`Server running on port ${port}`);
});