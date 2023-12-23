<template>
    <div class="table-header-wrapper">
        <el-form ref="form" :model="form" class="form-box" :key="timer + ''">
            <div class="items flex-start" :class="[labelWidth]" v-for="(item, index) in configSource"
                :key="toString(item.key.isArray ? item.key[0] : item.key) + index">
                <!-- input -->
                <el-form-item :label="item.label" class="table-header-item" :class="[item.labelClass]"
                    v-if="item.type == 'input'">
                    <el-input v-model="form[item.key]" :size="size" :placeholder="item.placeholder"
                        :clearable="item.clearable ? false : true"></el-input>
                </el-form-item>
                <!-- select -->
                <el-form-item :label="item.label" class="table-header-item" :class="[item.labelClass]"
                    v-if="item.type == 'select'">
                    <el-select class="width-box" :size="size" v-model="form[item.key]" :placeholder="item.placeholder"
                        :clearable="item.clearable ? false : true">
                        <el-option v-for="child in item.options" :key="child.value" :label="child.label"
                            :value="child.value"></el-option>
                    </el-select>
                </el-form-item>
                <!-- daterange -->
                <el-form-item :label="item.label" class="table-header-item" :class="[item.labelClass]"
                    v-if="item.type == 'daterange' || item.type == 'datetimerange' || item.type == 'date'">
                    <el-date-picker :size="size" v-model="form[item.key]" :type="item.type || 'daterange'"
                        range-separator="至" :clearable="item.clearable ? false : true" :picker-options="item.pickerOptions"
                        :disabledDate="item.disabledDate" :placeholder="item.placeholder"
                        :start-placeholder="item.startPlaceholder" :end-placeholder="item.endPlaceholder"
                        :format="item.format || 'yyyy-MM-dd'"></el-date-picker>
                </el-form-item>
                <!-- monthrange -->
                <el-form-item :label="item.label" class="table-header-item" :class="[item.labelClass]"
                    v-if="item.type == 'monthrange'">
                    <el-date-picker :size="size" v-model="form[item.key]" type="monthrange" range-separator="至"
                        :clearable="item.clearable ? false : true" :picker-options="item.pickerOptions"
                        :disabledDate="item.disabledDate" :start-placeholder="item.startPlaceholder"
                        :end-placeholder="item.endPlaceholder" :format="item.format || 'yyyy-MM'"
                        value-format="yyyy-MM"></el-date-picker>
                </el-form-item>
                <!-- select-input -->
                <el-form-item :label="item.label" class="table-header-item select-input" :class="[item.labelClass]"
                    v-if="item.type == 'selectInput'">
                    <el-input :size="size" :clearable="item.clearable ? false : true" :placeholder="item.placeholder"
                        v-model="form[item.key]">
                        <el-select v-model="form[item.selectKey]" slot="prepend" :placeholder="item.selectPlaceholder">
                            <el-option v-for="child in item.options" :key="child.value" :label="child.label"
                                :value="child.value"></el-option>
                        </el-select>
                    </el-input>
                </el-form-item>
                <!-- startAndEndInput -->
                <el-form-item :label="item.label" class="table-header-item start-and-end-input" :class="[item.labelClass]"
                    v-if="item.type == 'startAndEndInput'">
                    <el-input :size="size" :clearable="item.clearable ? false : true" :placeholder="item.startPlaceholder"
                        v-model="form[item.key[0]]"></el-input>
                    <span class="and">至</span>
                    <el-input :size="size" :clearable="item.clearable ? false : true" :placeholder="item.endPlaceholder"
                        v-model="form[item.key[1]]"></el-input>
                </el-form-item>
            </div>
            <div class="flex-start button-box">
                <el-button type="primary" :size="size" @click="search">筛选</el-button>
                <el-button :size="size" @click="clear">清空筛选</el-button>
                <slot name="button"></slot>
            </div>
        </el-form>
    </div>
</template>
<script>
export default {
    name: 'SearchForm',
    props: {
        /**
         * 配置项，使用方法见案例
         */
        config: {
            type: Array,
            default: () => [],
        },
        /**
         * 表单数据
         */
        form: {
            type: Object,
            default: () => { },
        },
        size: {
            type: String,
            default: 'mini',
        },
        /**
         * label最小宽度
         */
        labelWidth: {
            type: String,
            default: '',
        },
    },
    data() {
        return {
            configSource: [],
            timer: '',
            copyForm: {},
        };
    },
    methods: {
        search() {
            this.$emit('search', this.form);
        },
        clear() {
            this.$emit('update:form', Object.assign({}, this.copyForm));
            this.search();
        },
    },
    created() {
        this.timer = new Date().getTime();
    },
    mounted() {
        this.copyForm = Object.assign({}, this.form);
    },
    watch: {
        config: {
            handler(val) {
                this.configSource = val;
                this.timer = new Date().getTime();
                this.$forceUpdate();
            },
            deep: true,
            immediate: true,
        },
    },
};
</script>
<style lang="scss" scoped>
.flex-start {
    display: flex;
    align-items: center;
    justify-content: flex-start;
}

.flex-end {
    display: flex;
    align-items: center;
    justify-content: flex-end;
}

.flex-bt {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.flex-center {
    display: flex;
    align-items: center;
    justify-content: center;
}

.table-header-wrapper {
    .form-box {
        width: 100%;
        display: flex;
        justify-content: flex-start;
        flex-wrap: wrap;

        .items {
            margin-right: 24px;
        }

        .button-box {
            height: 40px;
        }
    }

    .table-header-item {
        display: flex;
        margin-bottom: 4px;
    }

    .start-and-end-input {
        .and {
            margin: 0 10px;
        }
    }
}
</style>
<style scoped>
.table-header-wrapper>>>.el-date-editor--daterange {
    width: 220px;
}

.table-header-wrapper>>>.el-date-editor .el-range-separator {
    width: auto;
}

.select-input>>>.el-form-item__content {
    width: 220px;
    display: flex;
    align-items: center;
}

.start-and-end-input>>>.el-form-item__content {
    width: 220px;
    display: flex;
    align-items: center;
}

.table-header-wrapper>>>.el-form-item__content {
    width: 220px;
}

.table-header-wrapper>>>.el-date-editor--monthrange.el-input,
.el-date-editor--monthrange.el-input__inner {
    width: 100%;
}

.select-input>>>.el-input-group__prepend {
    width: 100px;
}

.table-header-wrapper>>>.el-form-item__label {
    font-size: 14px;
    color: #606266;
    min-width: 90px;
}

.table-header-wrapper .items.label-100>>>.el-form-item__label {
    min-width: 100px;
}

.table-header-wrapper .items.label-110>>>.el-form-item__label {
    min-width: 110px;
}

.table-header-wrapper .items.label-120>>>.el-form-item__label {
    min-width: 120px;
}

.table-header-wrapper .items.label-130>>>.el-form-item__label {
    min-width: 130px;
}

.table-header-wrapper .items.label-140>>>.el-form-item__label {
    min-width: 140px;
}

.table-header-wrapper>>>.width-box {
    width: 100%;
}

.table-header-wrapper>>>.el-form-item.label-110 .el-form-item__label {
    width: 112px;
}
</style>
