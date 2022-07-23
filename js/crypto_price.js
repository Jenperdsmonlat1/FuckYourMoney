function getBTCPrice() {
    try {
        $.getJSON('https://min-api.cryptocompare.com/data/price?fsym=BTC&tsyms=EUR', function(data) {
            console.log(data.EUR);
            let btcElement = document.querySelector('#btc');
            btcElement.innerHTML = data.EUR + "€";
        });
    } catch {
        console.log('Une erreur est survenue.');
    }
}

function getETHPrice() {
    try {
        $.getJSON('https://min-api.cryptocompare.com/data/price?fsym=ETH&tsyms=EUR', function(data) {
            console.log(data.EUR);
            let btcElement = document.querySelector('#eth');
            btcElement.innerHTML = data.EUR + "€";
        });
    } catch {
        console.log('Une erreur est survenue.');
    }
}

function getUSDPrice() {
    try {
        $.getJSON('https://min-api.cryptocompare.com/data/price?fsym=USD&tsyms=EUR', function(data) {
            console.log(data.EUR);
            let btcElement = document.querySelector('#usd');
            btcElement.innerHTML = data.EUR + "€";
        });
    } catch {
        console.log('Une erreur est survenue.');
    }
}

function getXMRPrice() {
    try {
        $.getJSON('https://min-api.cryptocompare.com/data/price?fsym=XMR&tsyms=EUR', function(data) {
            console.log(data.EUR);
            let btcElement = document.querySelector('#xmr');
            btcElement.innerHTML = data.EUR + "€";
        });
    } catch {
        console.log('Une erreur est survenue.');
    }
}

function getXRPPrice() {
    try {
        $.getJSON('https://min-api.cryptocompare.com/data/price?fsym=XRP&tsyms=EUR', function(data) {
            console.log(data.EUR);
            let btcElement = document.querySelector('#xrp');
            btcElement.innerHTML = data.EUR + "€";
        });
    } catch {
        console.log('Une erreur est survenue.');
    }
}
