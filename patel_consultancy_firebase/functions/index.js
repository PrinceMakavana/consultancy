const functions = require('firebase-functions');
const express = require('express');

const app = express();
const bodyParser = require('body-parser')


app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

app.get('/timestamp', (req, res) => {
    res.send(`${Date.now()}`);
})


app.post('/xirr', (req, res) => {
    var xirr = require('xirr');

    var xirr_opt = [];

    req.body.forEach(e => {
        xirr_opt.push({ amount: e.amount, when: new Date(parseInt(e.when.Y), parseInt(e.when.m), parseInt(e.when.d)) })
    })
    // var rate = xirr([
    //     { amount: -1000, when: new Date(2012, 1, 1) },
    //     { amount: -1000, when: new Date(2013, 1, 1) },
    //     { amount: -1000, when: new Date(2014, 1, 1) },
    //     { amount: -1000, when: new Date(2015, 1, 1) },
    //     { amount: -1000, when: new Date(2016, 1, 1) },
    //     { amount: 6000, when: new Date(2017, 1, 1) },
    // ]);

    try {
        var rate = xirr(xirr_opt)
        res.status(200).json(parseFloat(rate * 100).toFixed(2));
    } catch (e) {
        res.status(500).send(e);
    }

})

app.listen(4000, () => console.log("Working on : localhost:4000"))
exports.app = functions.https.onRequest(app);
