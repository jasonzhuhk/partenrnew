<template>
    <div class="form-box-wrapper">
        <el-form :size="size" label-position="top" :model="formData">
            <div class="content">
                <div class="items" :class="[item.class]" v-for="item in config" :key="item.key">
                    <div class="child">
                        <p class="label">{{ item.label }}</p>
                        <el-form-item>
                            <el-input v-if="item.type === 'input'" :disabled="item.disabled"
                                v-model="formData[item.key]"></el-input>

                            <el-select v-else-if="item.type === 'select'" v-model="formData[item.key]" placeholder="请选择">
                                <el-option v-for="child in item.options" :key="child.value" :label="child.label"
                                    :value="child.value">
                                </el-option>
                            </el-select>

                            <el-radio-group v-else-if="item.type === 'radio'" v-model="formData[item.key]">
                                <el-radio v-for="child in item.options" :key="child.value" :label="child.label"
                                    :value="child.value"></el-radio>
                            </el-radio-group>


                        </el-form-item>
                    </div>
                </div>
                <div class="items" style="height: 0;"></div>
            </div>
        </el-form>
    </div>
</template>
<script>
export default {
    props: {
        formData: {
            type: Object,
            default: () => { }
        },
        config: {
            type: Array,
            default: () => []
        },
        size: {
            type: String,
            default: 'small'
        }
    },
    data() {
        return {

        }
    },
};
</script>
<style lang="scss" scoped>
.form-box-wrapper {
    .content {
        width: 100%;
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;

        .items {
            width: 32%;
            margin-bottom: 8px;

            &.width-100 {
                flex-basis: 100%;
            }

            .label {
                width: 100%;
                height: 18px;
                font-size: 12px;
                text-align: left;
                margin-bottom: 4px;
            }
        }
    }
}
</style>
<style scoped>
.form-box-wrapper>>>.el-input__inner {
    /* min-width: 200px !important; */
    width: 100% !important;
}

.form-box-wrapper>>>.el-select {
    width: 100% !important;
}
</style>
