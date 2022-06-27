// JSON
// Javascript Object Notation
// 객체를 텍스트로 , 텍스트를 객체로

const fs = require('fs');

const data = fs.readFileSync('./vocap.json', { encoding: 'utf-8' });

// console.log(typeof data); == string
// console.log(typeof JSON.parse(data)); == object

//parse = 객체로 만들기
//stringify = 스트링으로 만들기
let arr = JSON.parse(data);

const ob = {
    name: 'Daniel',
    age: 20,
    description: 'I go to School',
};

fs.writeFileSync('text.json', JSON.stringify(ob, null, 2));
