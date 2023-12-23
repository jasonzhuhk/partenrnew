<template>
    <div class="number-box-wrapper">
        <div class="items" v-for="(item, index) in list" :key="index">
            <div class="top">
                <span>{{ item.name }}</span>
                <!-- <img :src="require('@/assets/' + item.icon + '.png')" alt=""> -->
            </div>
            <div class="center">
                <p>{{ item.value }}</p>
                <el-button round size="mini" type="primary">
                    <i class="el-icon-top"></i>
                    {{ item.num }}
                </el-button>
            </div>
            <div class="bottom">查看全部</div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        list: {
            type: Array,
            default: () => []
        }
    },
    data() {
        return {

        }
    }
}
</script>
<style lang="scss" scoped>
.number-box-wrapper {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;

    .items {
        width: 49%;
        height: 172px;
        border-radius: 8px;
        background: #FFF;
        box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.25);
        overflow: hidden;
        position: relative;
        margin-bottom: 20px;

        .bottom {
            width: 100%;
            height: 40px;
            position: absolute;
            bottom: 0;
            left: 0;
            background: #FDF0F1;
            padding: 0 20px;
            color: #C73C47;
            font-family: PingFang HK;
            font-size: 14px;
            font-style: normal;
            font-weight: 600;
            line-height: 40px;
            cursor: pointer;
        }

        .top {
            display: flex;
            justify-content: space-between;
            padding: 20px 20px 8px 20px;

            span {
                color: #4E4E4E;
                font-family: PingFang HK;
                font-size: 16px;
                font-style: normal;
                font-weight: 600;
                line-height: 24px;
                /* 150% */
            }

            img {
                width: 40px;
                height: 40px;
                display: block;
            }
        }

        .center {
            padding: 0 20px;
            display: flex;
            justify-content: flex-start;
            align-items: flex-end;

            p {
                color: var(--black-100, #000);
                font-family: PingFang HK;
                font-size: 40px;
                font-style: normal;
                font-weight: 600;
                line-height: 40px;
                margin-right: 8px;
            }
        }
    }
}
</style>