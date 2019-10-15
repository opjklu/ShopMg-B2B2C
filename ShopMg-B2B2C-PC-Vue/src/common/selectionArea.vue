<template>
<div>
    <select class="behind" v-model="selectProvId1" @change="getCityArea(selectProvId1,'city','c')">
        <option v-if="selectProvId1 == '请选择'" value="请选择">请选择</option>
        <option :value="item.id" v-for="(item,index) in provList" :key="index">
            {{ item.name }}
        </option>
    </select>
    <select class="behind" v-model="selectCityId1" @change="getCityArea(selectCityId1,'area','t')">
        <option v-if="selectCityId1 == '请选择'" value="请选择">请选择</option>
        <option :value="item.id" v-for="(item,index) in cityList" :key="index">{{item.name}}</option>
    </select>
    <select class="behind" v-model="selectAreaId1" @change="getCityArea(selectAreaId1,'region','r')">
        <option v-if="selectAreaId1=='请选择'" value="请选择">请选择</option>
        <option :value="item.id" v-for="(item,index) in areaList" :key="index">{{item.name}}</option>
    </select>
</div>
    
</template>
<script>
export default {
  data() {
    return {
      provList: [], //省级列表
      selectProvId1: this.selectProvId,
      cityList: [], //市列表
      selectCityId1: this.selectCityId,
      areaList: [], //区列表
      selectAreaId1: this.selectAreaId,
      sign: false
    };
  },
  props: {
    selectProvId: "",
    selectCityId: "",
    selectAreaId: "",
    operateStyle: ""
  },
  watch: {
    operateStyle() {
      if (this.operateStyle == 1) {
        this.cityList = [];
        this.areaList = [];
      }
      this.sign = false;
    },
    selectProvId() {
      this.selectProvId1 = this.selectProvId;
      if (this.operateStyle > 1 && !this.sign) {
        this.getCityArea(this.selectProvId1, "city", "");
      }
    },
    selectCityId() {
      this.selectCityId1 = this.selectCityId;
      if (this.operateStyle > 1 && !this.sign) {
        this.getCityArea(this.selectCityId1, "area", "");
      }
    },
    selectAreaId() {
      this.selectAreaId1 = this.selectAreaId;
      if (this.operateStyle > 1 && !this.sign) {
        this.getCityArea(this.selectAreaId1, "region", "");
      }
    }
  },
  created() {
    this.getProvince();
  },
  methods: {
    //获取省
    getProvince() {
      this.HTTP(this.$httpConfig.regionLists, {
        parent_id:0
      }, "post").then(res => {
        this.provList = res.data;
      });
    },
    //获取市区
    getCityArea(id, name, status) {
      this.sign = status ? true : false;
      this.subgradeTransmit(id, name);
      if (name === "region") return;
      this.HTTP(
        this.$httpConfig.regionLists,
        {
           parent_id: id
        },
        "post"
      ).then(res => {
        if (status == "c") {
          this.selectCityId1 = "请选择";
          this.selectAreaId1 = "请选择";
          this.areaList = [];
        } else if (status == "t") {
          this.selectAreaId1 = "请选择";
        }
        if (name == "city") {
          this.cityList = res.data;
        } else if (name == "area") {
          this.areaList = res.data;
        }
      });
    },
    subgradeTransmit(id, sign) {
      this.$emit("subgradeTransmit", { addressId: id, sign: sign });
    }
  }
};
</script>

<style lang="less" scoped>
.behind {
  float: left;
  width: 120px;
  outline: none;
  margin-left: 5px;
  border-color: #ccc;
}
</style>