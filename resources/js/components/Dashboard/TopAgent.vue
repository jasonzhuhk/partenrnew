<template>
    <div class="top-agent-wrapper">
        <h4>Top 10 </h4>
        <div class="table">
            <!--<table-box :showPagination="false" :border="false" :tableHeader="tableHeader"-->
            <!--    :tableData="tableData"></table-box>-->
            <!-- <material-card color="green" title="Users"> -->
                <v-data-table :items="data" :headers="headers" :loading="loading"
                    loading-text="Loading... Please wait" :options.sync="options" :server-items-length="totalData">
                    <!-- <template v-slot:top>
                        <v-text-field v-model="options.search" prepend-icon="search" label="Search ......" class="mx-4">
                        </v-text-field>
                    </template> -->
                    <template slot="no-data">
                        <v-alert :value="true" color="error" icon="warning">
                            Sorry, No Users Yet.
                        </v-alert>
                    </template>
                </v-data-table>
            <!-- </material-card> -->


        </div>
    </div>
</template>
<script>
// import TableBox from './TableBox.vue'
export default {
    // components: { TableBox },
    data() {
        return {
            totalData: 0,
            loading: true,
            data:[  {
                            "id": 8,
                            "name": "sftestabc",
                            "email": "flasf@g.aomco",
                            "role": "user",
                            "verified": false,
                            "created_at": "2023-12-17T12:25:59.000000Z",
                            "updated_at": "2023-12-17T12:25:59.000000Z"
                        },],
            /*Search and Query Related Variable*/
            options: {
                page: 1,
                itemsPerPage: 10,
                search: undefined,
                sort: "desc",
                order_by:'tuinum'
            },
            headers: [
                { text: "Name", align: "left", sortable: false, value: "name" },
                { text: "Email", value: "email" },
       
            ],
            tableHeader: [

                {
                    text: '公司名稱',
                    value: 'agentId',
                },


            ],

            tableData:[
                        {
                            "id": 8,
                            "name": "sftestabc",
                            "email": "flasf@g.aomco",
                            "role": "user",
                            "verified": false,
                            "created_at": "2023-12-17T12:25:59.000000Z",
                            "updated_at": "2023-12-17T12:25:59.000000Z"
                        },
                        {
                            "id": 7,
                            "name": "dgdfgdfgdfg",
                            "email": "5110379021@qq.com",
                            "role": "user",
                            "verified": false,
                            "created_at": "2023-12-17T12:24:02.000000Z",
                            "updated_at": "2023-12-17T12:24:02.000000Z"
                        },
                        {
                            "id": 6,
                            "name": "test333",
                            "email": "test@gmail.com",
                            "role": "user",
                            "verified": false,
                            "created_at": "2023-12-17T06:18:12.000000Z",
                            "updated_at": "2023-12-17T12:16:58.000000Z"
                        },
                        {
                            "id": 5,
                            "name": "朱",
                            "email": "511079022@qq.com",
                            "role": "user",
                            "verified": false,
                            "created_at": "2023-12-17T04:27:41.000000Z",
                            "updated_at": "2023-12-17T04:27:41.000000Z"
                        },
                        {
                            "id": 3,
                            "name": "ZHU FAGANG",
                            "email": "smart2008@gmail.com",
                            "role": "user",
                            "verified": false,
                            "created_at": "2023-09-04T04:02:44.000000Z",
                            "updated_at": "2023-09-04T04:02:44.000000Z"
                        },
                        {
                            "id": 2,
                            "name": "zhufagang",
                            "email": "511079021@qq.com",
                            "role": "user",
                            "verified": false,
                            "created_at": "2023-09-02T08:23:48.000000Z",
                            "updated_at": "2023-09-02T08:23:48.000000Z"
                        },
                        {
                            "id": 1,
                            "name": "admin",
                            "email": "admin@gmail.com",
                            "role": "admin",
                            "verified": false,
                            "created_at": "2023-09-02T08:13:59.000000Z",
                            "updated_at": "2023-09-02T08:13:59.000000Z"
                        }
                    ]
        }
    },
    mounted() {
		this.fetch();
	},
    
    methods: {
        /*Fetch Users*/
        fetch() {
        return new Promise((resolve, reject) => {
            this.$store
            .dispatch("fetchUsers", this.options)
            .then((response) => {
                this.data = response.data.data;
                console.log("data", this.data);
                this.loading = false;
                this.totalData = response.data.meta.total;
            })
            .catch((error) => {
                // console.log(error.response.status);
            });
        });
        },
    }
}
</script>
<style lang="scss" scoped>
.top-agent-wrapper {
    width: 100%;
    width: 100%;
    padding: 0 24px;

    .table {
        width: 100%;
        height: 600px;
    }

    h4 {
        color: #4E4E4E;
        font-family: PingFang HK;
        font-size: 20px;
        font-style: normal;
        font-weight: 600;
        line-height: 20px;
        margin: 0;
        margin-bottom: 24px;
    }
}
</style>