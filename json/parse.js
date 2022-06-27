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
const obj = JSON.parse(json);
console.log(obj);

// rabbit.jump();

console.log(rabbit.birthDate.getDate());
// console.log(obj.birthDate.getDate()); error
