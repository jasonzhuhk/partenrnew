<template>
    <div class="sc-table-wrapper" id="sc-table-box" ref="tableBox">
        <el-table ref="table" v-if="height" :height="height" v-loading="loading" :data="tableData" row-key="id" :size="size"
            default-expand-all :empty-text="emptyText" :element-loading-text="loadingText"
            :element-loading-spinner="loadingIcon" :border="border" style="width: 100%;" @sort-change="handleSort"
            @filter-change="filterHandler" @selection-change="handleSelectionChange" @cell-mouse-enter="cellMouseEnter">
            <!-- 多选框 -->
            <el-table-column fixed v-if="type == 'selection'" :type="type" width="55" :selectable="checkSelect">

            </el-table-column>
            <template v-if="showColumn">
                <el-table-column v-for="(  th, index  ) in   tableHead  " min-height="46" :key="index" :prop="th.prop"
                    :label="th.label" :fixed="th.fixed" :sortable="th.custom ? 'custom' : false" :filters="th.filters"
                    :column-key="th.columnKey" :filtered-value="th.filteredValue" :filter-multiple="th.filterMultiple"
                    :min-width="th.width || th.minWidth" :width="th.minWidth" show-overflow-tooltip
                    :render-header="th.renderHeader || null">

                    <template slot-scope="scope">

                        <!-- 操作按钮 -->
                        <div v-if="th.type == 'operation'" class="flexbox">
                            <el-button v-for="(  item, key  ) in   scope.row[th.prop]  " :disabled="item.disabled"
                                :key="key" :style="item.style" class="operation-item" @click="item.clickFun(scope.row)"
                                type="text" :size="size">
                                {{ item.name }}
                            </el-button>
                        </div>
                        <!-- tag -->
                        <template v-else-if="th.type == 'tag'">
                            <el-tag v-for="child in scope.row[th.prop].list" :key="child.label" :type="child.type"
                                :size="scope.row[th.prop].size || size" :effect="scope.row[th.prop].effect">
                                {{ child.label }}
                            </el-tag>
                        </template>
                        <!-- popover -->
                        <template v-else-if="th.type == 'popover'">
                            <el-popover :placement="scope.row[th.prop].placement || 'top-start'"
                                :title="scope.row[th.prop].title || ''" :width="scope.row[th.prop].width || 200"
                                :trigger="scope.row[th.prop].trigger || 'hover'">
                                <div clas="popover-text">
                                    <p v-for="(  child, childIndex  ) in   scope.row[th.prop].list  " :key="childIndex">
                                        {{ child }}
                                    </p>
                                </div>
                                <el-link slot="reference" type="primary">{{ scope.row[th.prop].text }}</el-link>
                            </el-popover>
                        </template>
                        <!-- userInfo -->
                        <template v-else-if="th.type == 'userInfo'">
                            <div class="userInfo" v-if="typeof scope.row[th.prop] === 'object'">
                                <el-image class="avatar" :src="scope.row[th.prop].avatar"
                                    :fit="scope.row[th.prop].fit || 'cover'"></el-image>
                                <div class="text">
                                    <p>{{ scope.row[th.prop].name }}</p>
                                    <p>{{ scope.row[th.prop].mobile }}</p>
                                </div>
                            </div>
                            <div v-else>{{ scope.row[th.prop] }}</div>
                        </template>
                        <!-- userInfo -->
                        <template v-else-if="th.type == 'warpText'">
                            <div class="warpText">
                                <p v-for="(  item, index  ) in   scope.row[th.prop]  " :key="index">{{ item }}</p>
                            </div>
                        </template>
                        <!-- 排期选择 -->
                        <template v-else-if="th.type == 'schedule'">
                            <div class="schedule">
                                <el-checkbox-group v-model="scope.row[th.prop].value" class="listmain" value="" size="small"
                                    v-for="(  item, index  ) in   scope.row[th.prop].list  " :key="index">
                                    <el-checkbox :disabled="item.disabled" :label="item.date" border>
                                        <div class="day">{{ item.day }}</div>
                                        <div>{{ item.week }}</div>
                                    </el-checkbox>
                                </el-checkbox-group>
                            </div>
                        </template>
                        <!-- switch开关 -->
                        <template v-else-if="th.type == 'switch'">
                            <el-switch v-model="scope.row[th.prop].value" :disabled="scope.row[th.prop].disabled"
                                @change="switchChange(scope.row)">
                            </el-switch>
                        </template>

                        <!-- 可点击 -->
                        <template v-else-if="th.type == 'link'">
                            <el-link type="primary" @click.native="scope.row[th.prop].clickFun(scope.row)">{{
                                scope.row[th.prop].value }}</el-link>
                        </template>

                        <template v-else>
                            {{ scope.row[th.prop] }}
                        </template>
                    </template>
                </el-table-column>
            </template>

        </el-table>
        <div class="pagination flex-bt" v-if="showPagination">
            <div class="slot">
                <slot name="pagination"></slot>
            </div>
            <el-pagination @size-change="handleSizeChange" @current-change="handleCurrentChange" :current-page="currentPage"
                :page-sizes="pageSizes" :page-size="pageSize" layout="total, sizes, prev, pager, next, jumper"
                :total="total">
            </el-pagination>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        /**
         * table 类型 selection-多选
         */
        type: {
            type: String,
            default: () => ''
        },
        /**
         * 无数据时候展示文字
         */
        emptyText: {
            type: String,
            default: () => '暂无数据'
        },
        /**
         * 组件大小 包括table以及内部所有组件
         */
        size: {
            type: String,
            default: () => 'small'
        },
        /**
         * table是否有border
         */
        border: {
            type: Boolean,
            default: () => true
        },
        /**
         * 是否为loading状态
         */
        loading: {
            type: Boolean,
            default: () => false
        },
        /**
         * loading文字
         */
        loadingText: {
            type: String,
            default: () => '拼命加载中'
        },
        /**
         * loading icon
         */
        loadingIcon: {
            type: String,
            default: () => 'el-icon-loading'
        },
        /**
         * 列表数据
         */
        tableData: {
            type: Array,
            default: () => []
        },
        /**
         * 表头配置
         */
        tableHeader: {
            type: Array,
            default: () => []
        },
        /**
         * 页码按钮的数量，当总页数超过该值时会折叠	
        */
        currentPage: {
            type: Number,
            default: () => 0
        },
        /**
         * 每页显示个数选择器的选项设置
         */
        pageSizes: {
            type: Array,
            default: () => ['30', '50', '100', '200']
        },
        /**
         * 每页显示条目个数
         */
        pageSize: {
            type: Number,
            default: () => 10
        },
        /**
         * 总条目
         */
        total: {
            type: Number,
            default: () => 0
        },
        /**
         * 是否展示分页
         */
        showPagination: {
            type: Boolean,
            default: () => true
        },
        /**
        * 滚动条
        */
        showScrollBar: {
            type: Boolean,
            default: () => true
        }

    },
    data() {
        return {
            tableHead: [],
            height: null,
            showColumn: true
        }
    },
    mounted() {
        this.height = this.$refs.tableBox.offsetHeight + 'px'
    },
    methods: {
        switchChange(e) {
            this.$emit('switchChange', e)
        },
        /** 选择某行数据触发 */
        checkSelect(row) {
            return row.checked == 'false' ? false : true
        },
        /** 点击排序 */
        handleSort(row) {
            this.$emit('handleSort', row)
        },
        /**
         * 表单
         * @param {object} filters 
         */
        filterHandler(filters) {
            this.$emit('filter-events', filters)
        },
        /**
         * 左侧勾选事件，返回所有被选中的内容
         * @param {Array} val 
         */
        handleSelectionChange(val) {
            this.$emit('multipleSelection', val)
        },
        /**
         * 分页变化触发
         * @param {*} num 
         */
        handleSizeChange(num) {
            this.$emit('size-change', num)
        },
        /**
         * current 改变时会触发
         */
        handleCurrentChange(num) {
            this.$emit('current-change', num)
        },

        cellMouseEnter(row) {
            this.$emit('cell-mouse-enter', row)
        },

        /**
         * 配置表头
         */
        settingHeader() {
            this.$emit('settingHeader')
        }
    },
    watch: {
        tableData() {
            this.$nextTick(() => {
                this.$refs.table.doLayout()
            })
        },

        tableHeader: {
            handler: function (val) {
                this.showColumn = false
                let timer = setTimeout(() => {
                    clearTimeout(timer)
                    this.tableHead = JSON.parse(JSON.stringify(val))
                    this.showColumn = true
                    this.$nextTick(() => {
                        this.$refs.table.doLayout()
                    })
                }, 0);
            },
            deep: true,
            immediate: true
        }
    },

}
</script>
<style lang="scss" scoped>
.sc-table-wrapper {
    width: 100%;
    height: 100%;

    .flexbox {
        display: flex;
        justify-content: flex-start;
        flex-wrap: wrap;
    }

    .operation-item {
        margin-left: 0 !important;
        margin-right: 10px;
    }

    .schedule {
        display: flex;
        flex-wrap: wrap;
    }

    .warpText {
        p {
            font-size: 12px;
            margin: 0;
            padding-top: 4px;
            line-height: 14px;
        }
    }

    .pointer {
        cursor: pointer;
        font-size: 18px;
    }

    .pagination {
        margin-top: 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
    }

    .userInfo {
        display: flex;
        justify-content: flex-start;

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 8px;
        }

        .text {
            flex: 1;
            overflow: hidden;

            p {
                font-size: 12px;
                margin: 0;
                padding-top: 4px;
                line-height: 14px;
                overflow: hidden;
                white-space: nowrap;
                text-overflow: ellipsis;
            }
        }
    }
}

::v-deep {
    .listmain {
        position: relative;

        .el-checkbox.is-bordered.el-checkbox--small {
            height: auto;
            padding: 3px;
        }

        .el-checkbox__input {
            vertical-align: super;
            position: absolute;
            top: -6px;
            right: -5px;
        }

        .day {
            text-align: center;
        }

        .el-checkbox__label {
            padding-left: 0;
        }

        .el-checkbox {
            margin-left: 6px !important;
            margin-top: 5px;
            margin-right: 8px !important;
        }

        .disdiv {
            .el-checkbox__inner {
                background-color: #d73d3d;
            }
        }
    }
}
</style>
<style scoped>
.flex-bt {
    display: flex;
    align-items: center;
    justify-content: space-between;
}
</style>