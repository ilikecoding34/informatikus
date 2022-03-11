<template>

                <div class="card">
                    <div class="card-header">Adatok megjelenítése</div>
                    <div class="card-body">
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col">
                            <button type="button" :disabled="prevdisabled" class="btn btn-primary" @click="minusPage">Előző oldal</button>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-primary">Aktuális oldal: {{ pagecounter }}</button>
                            </div>
                            <div class="col">
                                <button type="button" :disabled="nextdisabled"  class="btn btn-primary" @click="addPage">Következő oldal</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-row">
                            <select class="custom-select" v-model="selected">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                            <span class="label label-default">Megjelenített elemek: {{ selected }}</span>
                        </div>
                    </div>
                        <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tipus</th>
                            <th scope="col">Név</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="data in displayedRecords" :key="data.id">
                                <th scope="row">{{data.id}}</th>
                                <td>{{data.type_nev.name}}</td>
                                <td>{{data.name}}</td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                </div>

</template>

<script>
    export default {
        data () {
            return {
                pagecounter: 0,
                selected: 10,
                prevdisabled: true,
                nextdisabled: false,
            }
        },
        props: ['datas'],
        computed: {
            displayedRecords() {
            return this.datas.slice(this.pagecounter*this.selected, (this.pagecounter+1)*this.selected);
            }
        },
        methods: {
            addPage() {
                this.pagecounter += 1;
                if(this.datas.length > (this.pagecounter+1)*this.selected){
                    this.prevdisabled = false;
                }else{
                    this.nextdisabled = true;
                }
            },
            minusPage() {
                this.pagecounter -= 1;
                if (this.pagecounter > 0){
                    this.nextdisabled = false;
                }else{
                    this.prevdisabled = true;
                }
            }
        }
    }
</script>
