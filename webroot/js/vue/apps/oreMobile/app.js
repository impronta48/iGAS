var addVm = new Vue({
	mixins: [formatMixin, httpMixin],
	el: '#ore-app',
	data: function () {
		return {
			loading: false,
			personaId: $personaId,
			personaName: $personaName,
			eattivita: $eattivita,
			allattivita: $allattivita,
			showattivita: false,
			cerca: null,
			faseAttivita: null,
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

		}
	},
	created() {
		this.loading = true;
	},
	computed: {
		titoloAttivita: function () {
			return this.showattivita ? 'Tutte le attivita' : 'attivita recenti';
		},
		filteredAttvità: {
			get: function () {
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
					list = list.filter(function (o) {
						return o['name'].toLowerCase().includes(sel);
					});
				}
				return list;
			},
			set: function (e) {},
		},
		filteredFase: {
			get: function () {
				let list = [];
				if (Object.keys(this.faseAttivita).length > 1) {
					list = Object.entries(this.faseAttivita);
					list = list.map(item => {
						return {
							item: item[0],
							name: item[1]
						};
					});
				}
				list.push({
					item: 0,
					name: '-- Non Definita --'
				});
				if (this.cerca != null) {
					let sel = this.cerca.toLowerCase();
					list = list.filter(function (o) {
						return o['name'].toLowerCase().includes(sel);
					});
				}
				return list;
			},
			set: function (e) {},
		},
	},
	watch: {
		selecAtt: function () {
			axios.post(app.url + "/faseattivita/getlist/" + this.selecAtt + ".json")
				.then(res => {
					this.cerca = null;
					if(Object.keys(res.data).length>1){
						this.faseAttivita = res.data[this.allattivita[this.selecAtt]];
					}else{
						this.faseAttivita = res.data;
					}
				})
				.catch(e => {
					//console.log(e)
				});
		}
	},
	methods: {
		getPosition(options) {
			return new Promise(function (resolve, reject) {
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
			this.getPosition()
				.then((position) => {
					var location = position.coords.latitude + "," + position.coords.longitude;
					var now = new Date();
					var data = {
						"Ora": {
							"eRisorsa": this.personaId,
							"data": moment(now).format("YYYY-MM-DD"),
							"start": moment(now).format("YYYY-MM-DD HH:mm"),
							"location_start": this.location,
							"dettagliAttivita": this.dettagli,
							"eAttivita": this.selecAtt,
							"faseattivita_id": this.selecFase,
						}
					};
					axios.post(app.url + "/ore/saveOra.json", data)
						.then(res => {
							if (res.data.result == '1') {
								this.getOra();
							} else {
								console.log(res)
							};
						})
						.catch(e => {
							console.log(e)
						});
				})
				.catch((err) => {
					console.error(err.message);
				});
		},
		setStop() {
			this.getPosition()
				.then((position) => {
					var location = position.coords.latitude + "," + position.coords.longitude;
					var nOre = Math.abs(new Date() - new Date(this.dateTimeStart)) / 3600000;
					nOre = nOre.toFixed(2);
					var now = new Date();
					var data = {
						"Ora": {
							"id": this.oraId,
							"numOre": nOre,
							"stop": moment(now).format("YYYY-MM-DD HH:mm"),
							"location_stop": location,
							"eRisorsa": this.personaId,
							"data": moment(this.dateTimeStart).format("YYYY-MM-DD"),
							"dettagliAttivita": this.dettagli,
							"eAttivita": this.selecAtt,
							"faseattivita_id": this.selecFase,
						}
					};
					axios.post(app.url + "/ore/saveOra.json", data)
						.then(res => {
							if (res.data.result == '1') {
								this.dateTimeStop = now;
								this.locationStop = location;
								this.nOre = nOre;
							} else {
								console.log(res)
							};
						})
						.catch(e => {
							console.log(e)
						});
				})
		},
		getOra() {
			axios.post(app.url + '/ore/getOrebyPersona/' + this.personaId + '/'+moment().format("DD")+'.json',{})
				.then(res => {
					if (res.data.length > 0) { 
						let oraCaricata = res.data;
						this.oraId = oraCaricata[0]['Ora']['id'];
						this.dateTimeStart = oraCaricata[0]['Ora']['start'];
						this.selecAtt = oraCaricata[0]['Ora']['eAttivita'];
						this.selecFase = oraCaricata[0]['Ora']['faseattivita_id'];
						this.locationStart = oraCaricata[0]['Ora']['location_start'];
						this.dettagli = oraCaricata[0]['Ora']['dettagliAttivita'];
						this.ora = oraCaricata[0];
					}
				})
				.catch(e => {
					console.log(e)
				});
		},
	}

});