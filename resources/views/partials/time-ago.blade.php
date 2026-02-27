@props(['datetime'])
<span
    data-time="{{ $datetime->format('c') }}"
    x-data="{
        text: '',
        init() {
            const iso = this.$el.getAttribute('data-time');
            const update = () => { this.text = moment(iso).locale('hu').fromNow(); };
            update();
            setInterval(update, 1000);
        }
    }"
    x-init="init()"
    x-text="text"
></span>
