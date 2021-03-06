// from https://www.reddit.com/r/adventofcode/comments/7hf5xb/2017_day_4_solutions/dqqjrq2/ By https://www.reddit.com/user/peasant-trip

//copy paste into chrome console

const phrases = document.body.textContent.trim().split('\n');
const noRepeats = (w, _, ws) => ws.filter(v => v === w).length === 1;
const sortLetters = w => [...w].sort().join('');
const isValid = f => ph => ph.split(' ').map(f).every(noRepeats);
const count = f => phrases.filter(isValid(f)).length;

console.log([w => w, sortLetters].map(count));
