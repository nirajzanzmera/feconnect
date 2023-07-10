Vue.component('data-table', {
        template: `
<div class="card">
    <div class="card-header">
        {{ response.table }}
        <a href="" class="pull-right" v-if="response.allow.creation" @click.prevent="creating.active = !creating.active">
            {{ creating.active ? 'Cancel' : '+ Add New' }}
        </a>
    </div>
    <div class="card-block">
        <div class="card card-primary"  v-if="creating.active">
            <div class="card-block">
                <form action="#" @submit.prevent="store()">
                    <div class="form-group row" v-for="column in response.updatable" :class="{ 'has-danger': creating.errors[column]}">
                        <label class="col-md-3 form-control-label" style="text-align: right;" :for="column">{{ column }}</label>
                        <div class="col-md-6">
                            <input type="text" :id="column" class="form-control" v-model="creating.form[column]">
                            <span class="help-block" v-if="creating.errors[column]">
                                <strong>
                                    {{ creating.errors[column][0] }}
                                </strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                            <button class="btn btn-success" type="submit">Create</button>
                        </div>
                    </div>
                    <br />
                </form>
            </div>
        </div>

        <form action="#" @submit.prevent="getRecords">
            <label for="search">
                <i class="fa fa-search"></i>
                Search
            </label>
            <div class="row row-fluid">
                <div class="form-group col-md-3">
                    <select class="form-control" v-model="search.column">
                        <option :value="column" v-for="column in response.displayable">{{column}}</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <select class="form-control" v-model="search.operator">
                        <option value="equals">=</option>
                        <option value="contains">contains</option>
                        <option value="starts_with">starts with</option>
                        <option value="ends_with">ends with</option>
                        <option value="greater_than">greater than</option>
                        <option value="less_than">less than</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <div class="input-group">
                        <input class="form-control" id="search" v-model="search.value">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </span>
                    </div>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="form-group col-md-10">
                <label for="filter">
                    <i class="fa fa-filter"></i>
                    Filter Records
                    </label>
                <input type="text" id="filter" class="form-control" v-model="quickSearchQuery">
            </div>
            <div class="form-group col-md-2">
                <label for="limit">Display Records</label>
                <select id="limit" class="form-control" v-model="limit" @change="getRecords">
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="1000">1000</option>
                    <option value="">All</option>
                </select>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr >
                    <th v-for="column in response.displayable">
                        <span class="sortable" @click="sortBy(column)">
                            {{ response.custom_columns[column] || column }}
                        </span>
                        <div
                            class="arrow "
                            v-if="sort.key === column"
                            :class="{ 'arrow-asc': sort.order === 'asc', 'arrow-desc': sort.order === 'desc'}"
                        ></div>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="record in filteredRecords">
                    <td v-for="columnValue, column in record">
                        <template v-if="editing.id === record.id && isUpdatable(column)">
                            <div class="form-group" :class="{ 'has-danger': editing.errors[column]}">
                                <template v-if="response.column_types[column] && response.column_types[column].type === 'select'">
                                    <select class="form-control" :value="columnValue" v-model="editing.form[column]">
                                        <option v-for="option in response.column_types[column].options" v-bind:value="option">
                                            {{ option }}
                                        </option>
                                    </select>
                                </template>
                                <template v-else>
                                    <input type="text" class="form-control"  v-model="editing.form[column]">
                                </template>
                                <span class="help-block" v-if="editing.errors[column]">
                                    <strong>
                                        {{ editing.errors[column][0] }}
                                    </strong>
                                </span>
                            </div>
                        </template>
                        <template v-else>
                            <template v-if="response.column_links[column] && columnValue">
                                <a v-bind:href="account_link(column, columnValue)">{{ formatted(columnValue) }}</a>
                            </template>
                            <template v-else>{{ formatted(columnValue) }}</template>
                        </template>
                    </td>
                    <td v-if="response.allow.update && response.buttons.length == 0">
                        <a href="#" class="btn btn-sm btn-primary" @click.prevent="edit(record)" v-if="editing.id !== record.id">Edit</a>
                        <template v-if="editing.id === record.id">
                            <a href="#" class="btn btn-sm btn-success" @click.prevent="update">Save</a>
                            <a href="#" class="btn btn-sm btn-danger" @click.prevent="editing.id = null">Cancel</a>
                        </template>
                    </td>
                    <td v-if="response.buttons.length > 0">
                        <div class="btn-group" v-for="btn in response.buttons">
                            <a v-bind:href="btn.route + record.id + btn.method" class="btn btn-sm btn-primary">{{ btn.label }}</a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
            
        `,
        props: ['endpoint', 'limit'],
        data () {
            return {
                response: {
                    table: '',
                    displayable: [],
                    records : [],
                    allow: {},
                    columnTypes: [],
                },
                sort: {
                    key: '',
                    order: ''
                },
                quickSearchQuery: '',
                editing: {
                    id: null, 
                    form: {},
                    errors: []
                },
                creating: {
                    active: false,
                    form: {},
                    errors: []
                },   
                /* limit: '', */
                search: {
                    value: '',
                    operator: 'equals',
                    column: 'id'
                },
            }
        },
        computed: {
            filteredRecords () {
                var data = this.response.records
                data = data.filter( (row) => {
                    return Object.keys(row).some( (key) => {
                           return String(row[key]).toLowerCase().indexOf(this.quickSearchQuery.toLowerCase()) > -1
                    })
                })
                if (this.sort.key) {
                    data = _.orderBy(data, (i) => {
                        if( this.sort.key.toLowerCase().indexOf('date') > -1 || this.sort.key.toLowerCase().indexOf('stamp') > -1 || this.sort.key === 'created_at' ){
                            var value = moment(i[this.sort.key]); 
                            var num = (isNaN(parseFloat( value.format('YYYYMMDD'))) === true) ? 0 : parseFloat( value.format('YYYYMMDD') ) 
                            return num
                        } else {
                            var value = i[this.sort.key]
                            if(!isNaN(parseFloat(value))) {
                                return parseFloat(value)
                            }
                            //nullsssss
                            if(value == null) {
                                return '';
                            }
                            return String(i[this.sort.key].toLowerCase())
                        }
                    }, this.sort.order)
                    return data;
                }
            }
        },
        methods: {
            getRecords() {
                return axios.get(`${this.endpoint}?${this.getParams()}`).then((response) => {
                    this.response = response.data.data;
                    this.sort.key = this.response.sortKey;
                    this.sort.order = this.response.sortOrder;
                    this.search.column = this.response.searchColumn;
                });
            },
            getParams() {
              return jQuery.param({
                limit: this.limit,
                column: this.search.column,
                operator: this.search.operator,
                value: this.search.value,
              });
            },
            sortBy(column) {
                this.sort.key = column
                this.sort.order = this.sort.order === 'asc' ? 'desc' : 'asc'
            },
            edit(record) {
                this.editing.errors = []
                this.editing.id = record.id
                this.editing.form = _.pick(record, this.response.updatable)
            },
            isUpdatable(column){
                return this.response.updatable.includes(column);
            },
            customLink(route, id){
                window.location = route + id
            },
            update() {
                axios.patch(`${this.endpoint}/${this.editing.id}`, this.editing.form).then(() => {
                    this.getRecords().then(() => {
                        this.editing.id = null
                        this.editing.form = {}                    
                    });
                }).catch((error) => {
                    if(error.response.status === 422) {
                        this.editing.errors = error.response.data.errors
                    }
                });
            },
            store() {
                axios.post(`${this.endpoint}`, this.creating.form).then(() => {
                    this.getRecords().then(() => {
                        this.creating.active = false
                        this.creating.form = {}
                        this.creating.errors = []
                    });
                }).catch((error) => {
                    if(error.response.status === 422) {
                        this.creating.errors = error.response.data.errors
                    }
                });
            },
            formatted(value) {
                if (this.isCarbonDate(value)) {
                    return value.date.substring(0,19);
                }
                return value;
            },
            account_link(column,value) {
                return this.response.column_links[column].replace('-+'+column+'-+', value);
            },
            isCarbonDate(value) {
                if (typeof value === 'object'
                    && value !== null
                    && value.date
                    && value.timezone_type
                    && value.timezone)
                {
                    return true;
                }
                return false;
            },
        },
        mounted() {
            this.getRecords();
        },
    });
    new Vue({
        el: "#app",
    })


