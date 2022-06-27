const rabbit = {
    name: 'tori',
    color: 'white',
    size: null,
    birthDate: new Date(),
    symbol: Symbol('id'),
    jump: () => {
        console.log(`${this.name} can jump!`);
    },
};

json = JSON.stringify(rabbit);
console.log(json); // 메소드와 내장함수는 안됨

json = JSON.stringify(rabbit, ['name', 'color']);
console.log(json);

console.log('-------------------------------');

json = JSON.stringify(rabbit, (key, value) => {
    // console.log(`key: ${key}, value: ${value}`);
    return key === 'name' ? 'ellie' : value;
});
console.log(json);
