<template>
  <div class="compared">
    <!-- 头部 -->
    <head-com></head-com>
		<div class="center">
			<div class="top">
				<el-breadcrumb separator-class="el-icon-arrow-right">
					<el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
					<el-breadcrumb-item :to="{ path: '/brand' }">品牌</el-breadcrumb-item>
					<el-breadcrumb-item>对比</el-breadcrumb-item>
				</el-breadcrumb>
			</div>
		</div>
    <div class="view">
      <el-table
        :data="data"
        border>
        <el-table-column
          prop="brand_name"
          label="品牌"
          width="100">
        </el-table-column>
        <el-table-column
          prop="shop_name"
          label="店铺名称"
          width="150">
        </el-table-column>
        <el-table-column
          prop="title"
          label="标题"
          width="150">
        </el-table-column>
        <el-table-column
          prop="one_name"
          label="一级分类"
          width="150">
        </el-table-column>
        <el-table-column
          prop="two_name"
          label="二级分类"
          width="150">
        </el-table-column>
        <el-table-column
          prop="three_name"
          label="三级分类"
          width="150">
        </el-table-column>
        <el-table-column
          prop="price_market"
          label="原价"
          width="150">
        </el-table-column>
        <el-table-column
          prop="price_member"
          label="现价"
          width="150">
        </el-table-column>
      </el-table>
    </div>
    <!-- 底部 -->
    <foot-com></foot-com>
  </div>
</template>
<script>
export default {
  name: 'compared',
  data () {
    return {
      data: []
    }
  },
  created () {
    console.log(this.$route.params)
    this.HTTP(this.$httpConfig.contrastResult, {
      contrast_id: this.$route.params.id
    }, 'post').then(res => {
      this.data = res.data
      console.log(res.data)
    })
  }
}
</script>
<style>
.view {
  display: flex;
  margin: 50px;
  justify-content: center;
}
</style>
