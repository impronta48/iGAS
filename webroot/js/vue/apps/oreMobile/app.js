var addVm = new Vue({
    mixins: [formatMixin, httpMixin],
    el: '#ore-app',
    data: function() {
        return {
            loading: false,
            personaId: $personaId,
            personaName: $personaName,
            eattivita: $eattivita,
            allattivita: $allattivita,
            showattivita: false,
            cerca: null,
            // faseAttivita: null,
            filteredFase: [],
            locationStart: null,
            locationStop: null,
            dateTimeStart: null,
            dateTimeStop: null,
            selecAtt: null,
            selecFase: null,
            dettagli: null,
            nOre: 0,
            oraId: null,
            ora: null,
            riepilogo: false,
            mesError: null,

        }
    },
    created() {
        this.getOra();
        this.loading = true;
    },
    computed: {
        titoloAttivita: function() {
            return this.showattivita ? 'Tutte le attivita' : 'attivita recenti';
        },
        filteredAttvità: {
            get: function() {
                let list = [];
                if (!this.showattivita) {
                    list = Object.entries(this.eattivita);
                } else {
                    list = Object.entries(this.allattivita)
                }
                list = list.map(item => {
                    return {
                        item: item[0],
                        name: item[1]
                    };
                });
                if (this.cerca != null) {
                    let sel = this.cerca.toLowerCase();
                    list = list.filter(function(o) {
                        return o['name'].toLowerCase().includes(sel);
                    });
                }
                return list;
            },
            set: function(e) {},
        },

    },
    watch: {
        cerca: function(val) {
            let sel = val.toLowerCase();
            this.filteredFase = this.filteredFase.filter(function(o) {
                return o['name'].toLowerCase().includes(sel);
            });
        }
    },
    methods: {
        getFasi(id) {
            this.selecFase = null;
            axios.post(url + "/faseattivita/getlist/" + id + ".json")
                .then(res => {
                    var faseAttivita = [];
                    if (Object.keys(res.data).length > 1) {
                        faseAttivita = res.data[this.allattivita[id]];
                    }
                    list = Object.entries(faseAttivita);
                    list = list.map(item => {
                        return {
                            item: item[0],
                            name: item[1]
                        };
                    });
                    list.push({
                        item: 0,
                        name: '-- Non Definita --'
                    });
                    this.filteredFase = list;
                })
                .catch(e => {
                    //console.log(e)
                });
        },
        getPosition(options) {
            return new Promise(function(resolve, reject) {
                navigator.geolocation.getCurrentPosition(resolve, reject, options);
            });
        },
        toggleData() {
            this.showData = !this.showData;
            this.showTime = false;
        },
        toggleTime() {
            this.showData = false;
            this.showTime = !this.showTime;
        },
        toggleattivita() {
            this.showattivita = !this.showattivita;
        },
        setStart() {
            var now = new Date();
            var data = {
                "Ora": {
                    "eRisorsa": this.personaId,
                    "numOre": 0,
                    "data": moment(now).format("YYYY-MM-DD"),
                    "start": moment(now).format("YYYY-MM-DD HH:mm"),
                    "location_start": null,
                    "dettagliAttivita": this.dettagli,
                    "eAttivita": this.selecAtt,
                    "faseattivita_id": this.selecFase,
                }
            };
            this.getPosition()
                .then((position) => {
                    var location = position.coords.latitude + "," + position.coords.longitude;
                    data['Ora']['location_start'] = location;
                    this.salvaOra(data);
                })
                .catch((err) => {
                    this.mesError = 'Non è stato possibile recuperare la posizione, si prega di attivare la geolocalizzazione.';
                    this.salvaOra(data);
                });
        },
        setStop() {
            var nOre = Math.abs(new Date() - new Date(this.dateTimeStart)) / 3600000;
            nOre = nOre.toFixed(2);
            var now = new Date();
            var data = {
                "Ora": {
                    "id": this.oraId,
                    "numOre": nOre,
                    "stop": moment(now).format("YYYY-MM-DD HH:mm"),
                    "location_stop": null,
                    "eRisorsa": this.personaId,
                    "data": moment(this.dateTimeStart).format("YYYY-MM-DD"),
                    "dettagliAttivita": this.dettagli,
                    "eAttivita": this.selecAtt,
                    "faseattivita_id": this.selecFase,
                }
            };
            this.getPosition()
                .then((position) => {
                    var location = position.coords.latitude + "," + position.coords.longitude;
                    data['Ora']['location_stop'] = location;
                    this.salvaOra(data);
                    this.riepilogo = true;
                })
                .catch((err) => {
                    this.salvaOra(data);
                    this.riepilogo = true;
                });
        },
        salvaOra(data) {
            axios.post(url + "/ore/saveOra.json", data)
                .then(res => {
                    if (res.data.result == '1') {
                        this.getOra()
                    } else {
                        this.mesError = 'Non è stato possibile salvare l\'attività.';
                        // console.log(res);
                    };
                })
                .catch(e => {
                    this.mesError = 'Non è stato possibile salvare l\'attività.';
                    // console.log(res);
                });
        },

        getOra() {
            axios.post(url + '/ore/getOreByPersona/' + this.personaId + '/' + moment().format("DD") + '.json', {})
                .then(res => {
                    if (res.data.length > 0) {
                        let oraCaricata = res.data;
                        this.oraId = oraCaricata[0]['Ora']['id'];
                        this.dateTimeStart = oraCaricata[0]['Ora']['start'];
                        this.dateTimeStop = oraCaricata[0]['Ora']['stop'];
                        this.selecAtt = oraCaricata[0]['Ora']['eAttivita'];
                        this.selecFase = oraCaricata[0]['Ora']['faseattivita_id'];
                        this.locationStart = oraCaricata[0]['Ora']['location_start'];
                        this.locationStop = oraCaricata[0]['Ora']['location_stop'];
                        this.dettagli = oraCaricata[0]['Ora']['dettagliAttivita'];
                        this.nOre = oraCaricata[0]['Ora']['numOre'];
                        this.mesError = null;
                        this.ora = oraCaricata[0];
                    } else {
                        this.oraId = null;
                        this.dateTimeStart = null;
                        this.dateTimeStop = null;
                        this.selecAtt = null;
                        this.selecFase = null;
                        this.locationStart = null;
                        this.locationStop = null;
                        this.dettagli = null;
                        this.nOre = null;
                        this.ora = null;
                        this.mesError = null;

                    }
                })
                .catch(e => {
                    this.mesError = 'Si è verificato un errore nel recupero dell\'ultima attività caricata.';
                });
        },
    }

});