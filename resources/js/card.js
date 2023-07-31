import Card from './components/Card'

Nova.booting((app, store) => {
    app.component('nova-server-metrics', Card)
})