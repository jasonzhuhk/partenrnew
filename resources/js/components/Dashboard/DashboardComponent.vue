<template>
	<div class="home-wrapper">
		<div class="tab">
			<el-radio-group v-model="tabActive" size="small">
				<el-radio-button label="1">最近12個月</el-radio-button>
				<el-radio-button label="2">最近30日</el-radio-button>
				<el-radio-button label="3">最近7日</el-radio-button>
			</el-radio-group>
		</div>
		<div class="content">
			<div class="left">
				<NumberBox :list="numberList"></NumberBox>
				<div class="chartDom" id="chartDom"></div>
			</div>
			<div class="right">
				<TopAgent></TopAgent>
			</div>
		</div>
	</div>
</template>

<script>
import NumberBox from './NumberBox'
import TopAgent from './TopAgent'
import * as echarts from 'echarts/core';
import { GridComponent } from 'echarts/components';
import { BarChart } from 'echarts/charts';
import { CanvasRenderer } from 'echarts/renderers';
echarts.use([GridComponent, BarChart, CanvasRenderer]);


export default {
	name: 'Home',
	components: {  TopAgent,NumberBox },
	data() {
		return {
			tabActive: '1',
			numberList: [
				{ name: '注册代理數目', icon: 'index-icon-1', value: '520', num: '10%' },
				{ name: '推薦用戶數目', icon: 'index-icon-2', value: '1,560k', num: '10%' },
				{ name: '結算金額', icon: 'index-icon-3', value: '$156m', num: '10%' },
				{ name: '', icon: 'index-icon-4', value: '589k', num: '10%' }
			]

		}
	},
	mounted() {
		this.initChart();
	},
	methods: {
		initChart() {
			var chartDom = document.getElementById('chartDom');
			var myChart = echarts.init(chartDom);
			var option;

			option = {
				color: '#C73C47',
				xAxis: {
					type: 'category',
					data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
				},
				yAxis: {
					type: 'value'
				},
				series: [
					{
						data: [120, 200, 150, 80, 70, 110, 130],
						type: 'bar'
					}
				]
			};
			option && myChart.setOption(option)
		}
	}
}
</script>
<style lang="scss" scoped>
.home-wrapper {
	width: 100%;
	height: 100%;
	padding: 14px;

	.tab {
		margin-bottom: 18px;
	}

	.content {
		display: flex;
		justify-content: space-between;

		.left {
			width: 49%;

			.chartDom {
				width: 100%;
				height: 400px;
			}
		}

		.right {
			width: 49%;
		}
	}
}
</style>


<!-- <template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <material-card
                    color="green"
                    :title="'Welcome,  '+getProfile.name"
                >
                    <div class="card-body">
                        This is Dashboard . You can Edit this at
                        resources>js>components>Dashboard>DashboardComponent.vue
                    </div>
                </material-card>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';

    export default {

        computed: {
            ...mapGetters([
                'getProfile'
            ])
        },
        mounted() {

        },
    }
</script> -->
