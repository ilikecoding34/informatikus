<template>
    <div class="container">
        <p class="card-text text-right">
            <small class="text-muted">Utoljára frissítve: {{ interval }}</small>
        </p>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                interval: null,
                time: null
                }
            },
        methods:{
            getDifference(){
                let now = moment().format('YYYY-MM-DD HH:mm:ss');
                let then = moment(this.inputtime).format('YYYY-MM-DD HH:mm:ss');

                var differencetext = "";
                var types = ['seconds', 'minutes', 'hours', 'days', 'weeks', 'months', 'years'];
                var typetext = ['másodperc', 'perc', 'óra', 'nap', 'hét', 'hónap', 'év'];

                for(let i = types.length-1; i > 0; i--){
                    let difference = moment(now).diff(then, types[i], true);
                    if(difference > 1){
                        differencetext = difference + " " + typetext[i];
                        break;
                    }
                }

                let seconds = moment(now).diff(then, 'seconds') % 60;
                let minutes = moment(now).diff(then, 'minutes') %60;
                let hours = moment(now).diff(then, 'hours') % 24;
                let days = moment(now).diff(then, 'days') % 7;
                let weeks = moment(now).diff(then, 'weeks') % 4;
                let months = moment(now).diff(then, 'months');
                hours = hours > 0 ? hours + ' óra - ' : '';
                days = days > 0 ? days + ' nap - ' : '';
                weeks = weeks > 0 ? weeks + ' hét - ' : '';
                months = months > 0 ? months + ' hónap - ' : '';

                this.interval =  months + weeks + days + hours + minutes + ' perc - ' + seconds + ' másodperc';
            },
        },
        computed: {
            getNow() {
                let now = moment().format('YYYY-MM-DD HH:mm:ss');
                return now;
            },
        },
        props: ['inputtime'],
        mounted() {
            setInterval(this.getDifference, 1000);
            console.log('Component mounted.');
        }
    }
</script>
