<template>
  <div class="look-progress l">
    <div>
      <div class="top">
        <ul class="l">
          <li v-for="(item,index) in titleList" @click="viewSwitch(index)" :key="index" :class="{line:isline == index}">
            <p>{{item}}</p>
          </li>
        </ul>
      </div>
      <div class="base" v-show="isline == 0">
        <div class="info" v-if="personData.length == 0">暂无个人信息</div>
        <div class="progress-info" v-if="personData.length !=0">
          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="list">
            <tr>
              <th colspan="4">
                <span class="black bold size14 shop_news">店铺及联系人信息</span>
              </th>
            </tr>
            <tr>
              <td align="right" width="20%" class="black border_right">店铺名称：</td>
              <td align="left" width="15%" class=" space">{{personData.store_name}}</td>
              <td align="right" width="20%" class="black border_right">申请人：</td>
              <td align="left" width="15%" class=" space">{{personData.person_name}}</td>
            </tr>
            <tr>
              <td align="right" width="20%" class="black border_right">联系人手机：</td>
              <td align="left" width="15%" class="space">{{personData.mobile}}</td>
              <td align="right" width="20%" class="black border_right">身份证号码：</td>
              <td align="left" width="15%" class="space">{{personData.id_card}}</td>
            </tr>
            <tr>
              <td width="20%" align="right" class="black border_right">身份证正面：</td>
              <td colspan="3" class="space">
                <img :src="URL+personData.idcard_positive" alt="">
              </td>
            </tr>
            <tr>
              <td width="20%" align="right" class="black border_right">身份证反面：</td>
              <td colspan="3" class="space">
                <img :src="URL+personData.other_side" alt="">
              </td>
            </tr>
          </table>
          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="list">
            <tr>
              <th colspan="4">
                <span class="black bold size14 shop_news">打款信息</span>
              </th>
            </tr>
            <tr>
              <td align="right" width="20%" class="black border_right">微信：</td>
              <td align="left" width="15%" class=" space">{{personData.wx_account}}</td>
              <td align="right" width="20%" class="black border_right">支付宝：</td>
              <td align="left" width="15%" class=" space">{{personData.alipay_account}}</td>
            </tr>
            <tr>
              <td align="right" width="20%" class="black border_right">开户行：</td>
              <td align="left" width="15%" class=" space">{{personData.bank_name}}</td>
              <td align="right" width="20%" class="black border_right">银行卡账号：</td>
              <td align="left" width="15%" class=" space">{{personData.bank_account}}</td>
            </tr>
          </table>
          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="list">
            <tr>
              <th colspan="4">
                <span class="black bold size14 shop_news">入驻进度</span>
              </th>
            </tr>
            <tr>
              <td align="right" class="black border_right"> 申请时间：</td>
              <td class="space">{{personData.create_time|formatDate}}</td>
              <td align="right" class="black border_right"> 更新时间：</td>
              <td class="space">{{personData.update_time|formatDate}}</td>
            </tr>
            <tr>
              <td align="right" class="black border_right"> 申请状态：</td>
              <td colspan="3" class="space">{{applyList[personData.status]}}
                <button v-if="personData.status == 2" class="payment-btn fr" @click="payment">支付</button>
              </td>
            </tr>
          </table>
          <div class="base" style="text-align:center;margin-top:10px" v-show="istastus">
            <p>提示：当您的开店申请状态为 --已提交申请-- 或 --审核失败-- 时，可编辑开店信息</p>
            <el-row class="personage" >
              <el-button type="info" plain @click="alter">编辑信息</el-button>
            </el-row> 
          </div>
        </div>
  
      </div>
      <div class="base" v-show="isline == 1">
        <div class="info" v-if="companyData.length == 0">暂无企业信息</div>
        <div class="progress-info" v-if="companyData.length !=0">
          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="list">
            <tr>
              <th colspan="4">
                <span class="black bold size14 shop_news">公司及联系人信息</span>
              </th>
            </tr>
            <tr>
              <td align="right" width="20%" class="black border_right">公司名称：</td>
              <td align="left" width="15%" class=" space">{{companyData.company_name}}</td>
              <td align="right" width="20%" class="black border_right">申请人：</td>
              <td align="left" width="15%" class=" space">{{companyData.name}}</td>
            </tr>
            <tr>
              <td align="right" width="20%" class="black border_right">注册资金数：</td>
              <td align="left" width="15%" class=" space">{{companyData.registered_capital}}</td>
              <td align="right" width="20%" class="black border_right">联系人手机：</td>
              <td align="left" width="15%" class="space">{{companyData.mobile}}</td>
            </tr>
          </table>
          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="list">
            <tr>
              <th colspan="4">
                <span class="black bold size14 shop_news">营业执照信息（副本）</span>
              </th>
            </tr>
            <tr>
              <td align="right" class="black border_right">营业执照号：</td>
              <td class="space">{{companyData.license_number}}</td>
              <td align="right" class="black border_right">法定经营范围：</td>
              <td class="space">{{companyData.scope_of_operation}}</td>
            </tr>
            <tr>
              <td align="right" class="black border_right">营业执照开始日期：</td>
              <td class="space">{{companyData.validity_start}}</td>
              <td align="right" class="black border_right">营业执照结束日期：</td>
              <td class="space">{{companyData.validity_end}}</td>
            </tr>
  
            <tr>
              <td width="20%" align="right" class="black border_right">营业执照电子版：</td>
              <td colspan="3" class="space">
                <img :src="URL+companyData.electronic_version" alt="">
              </td>
            </tr>
          </table>
          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="list">
            <tr>
              <th colspan="2">
                <span class="black bold size14 shop_news">组织机构代码证</span>
              </th>
            </tr>
            <tr>
              <td align="right" class="black border_right">组织机构代码：</td>
              <td class="space">{{companyData.organization_code}}</td>
            </tr>
            <tr>
              <td width="20%" align="right" class="black border_right">组织机构代码证电子版：</td>
              <td width="90%" class="space">
                <img :src="URL+companyData.organization_electronic" alt="">
              </td>
            </tr>
          </table>
          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="list">
            <tr>
              <th colspan="2">
                <span class="black bold size14 shop_news">一般纳税人证明</span>
              </th>
            </tr>
            <tr>
              <td width="20%" align="right" class="black border_right">一般纳税人证明电子版：</td>
              <td width="90%" class="space">
                <img :src="URL+companyData.taxpayer_certificate" alt="">
              </td>
            </tr>
          </table>
          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="list">
            <tr>
              <th colspan="4">
                <span class="black bold size14 shop_news">入驻进度</span>
              </th>
            </tr>
            <tr>
              <td align="right" class="black border_right"> 申请时间：</td>
              <td class="space">{{companyData.create_time|formatDate}}</td>
              <td align="right" class="black border_right"> 更新时间：</td>
              <td class="space">{{companyData.update_time|formatDate}}</td>
            </tr>
            <tr>
              <td align="right" class="black border_right"> 申请状态：</td>
              <td colspan="3" class="space">{{applyList[companyData.status]}}
                <button v-if="companyData.status == 2" class="payment-btn fr" @click="payment">支付</button>
              </td>
            </tr>
          </table>
        </div>
        <div class="base" style="text-align:center;margin-top:10px" v-show="istastus">
          <p>提示：当您的开店申请状态为 --已提交申请-- 或 --审核失败-- 时，可编辑开店信息</p>
          <el-row class="personage" >
            <el-button type="info" plain @click="alter">编辑信息</el-button>
          </el-row> 
        </div>
      </div>
      
      
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        titleList: ['个人入驻进度', '企业入驻进度'],
        isline: 0,
        companyData: [],
        personData: [],
        applyList: ['已提交申请', '缴费完成', '审核成功', '审核失败', '缴费审核失败', '审核通过开店'],
        payInfo: 0,
        payId:'',
        istastus:false,
        gt:null,//1为个人修改，2为企业修改
      }
    },
    created() {
      // this.getCompany();//企业//2
      this.getPerson(); //个人
    },
    methods: {
      alter() {
        if (this.gt==1) {
          sessionStorage.setItem('redact',JSON.stringify(this.personData));
          this.$router.push({path:'/halfwayone'})
        } else {
          sessionStorage.setItem('company',JSON.stringify(this.companyData));
          this.$router.push({path:'/companyone'})
        }
        
      },
      payment() {
        this.HTTP(this.$httpConfig.getPayInfo, {
          id: this.payId
        }, 'post').then((res) => {
          this.payInfo = res.data.data;
          this.$router.push({
            path: '/pay',
            query: {
              price: this.payInfo
            }
          });
        }).catch(res => {
          console.log(res.data.message)
        })
  
      },
      viewSwitch(index) {
        if (index == 0) {
          this.getPerson();
        } else {
          this.getCompany();
        }
        this.isline = index;
      },
      //获取开店信息
      getPerson() {
        this.HTTP(this.$httpConfig.personProgress, '', 'post').then((res) => {
          this.personData = res.data.data;
          
          this.payId = this.personData.id;
          if (res.data.data.status==='0'||res.data.data.status==='3') {
            this.istastus=true;
            this.gt=1;
          } else {
            this.gt=null;
            this.istastus=false;
          }
        }).catch(res => {
          //console.log(res.data.message)
          this.$message(`${res.data.message}`);
        })
      },
      getCompany() {
        this.HTTP(this.$httpConfig.companyProgress, '', 'post').then((res) => {
          this.companyData = res.data.data;
          if (res.data.data.status==='0'||res.data.data.status==='3') {
            this.istastus=true;
            this.gt=2;
          } else {
            this.gt=null;
            this.istastus=false;
          }
          this.payId = this.companyData.id
        }).catch(res => {
          alert(res.data.message)
        })
      }
    }
  }
</script>

<style lang="less" scoped>
  .info{
    font-size:30px;
    color:gray;
    text-align: center;
    padding-top:200px;
  }
  .personage{
    text-align: center;
    margin-top:10px;
    background:#ddd;
  }
  .l {
    float: left;
  }
  
  .r {
    float: right;
  }
  
  .center {
    width: 1200px;
    margin: 0 auto;
    height: 100%;
  }
  
  .look-progress {
    height: 956px;
    width: 980px;
    background: #fff;
    margin: 16px 0;
    .top {
      overflow: hidden;
      margin: 14px 17px 12px;
      border-bottom: 1px solid #e7e7e7;
      line-height: 37px;
      ul {
        li {
          height: 37px;
          line-height: 37px;
          text-align: center;
          margin-top: 10px;
          cursor: pointer;
          float: left;
          font-size: 14px;
          color: #666;
          width: 120px;
          p {
            border-right: 1px solid #e7e7e7;
          }
        }
        .line {
          border-bottom: 2px solid red;
          font-size: 12px;
          color: red;
        }
      }
    }
    .base {
      overflow: hidden;
      margin: 0 17px;
      .list {
        border-left: 1px solid #ddd;
        border-right: 1px solid #ddd;
        border-top: 1px solid #ddd;
        margin-top: 15px;
        tr {
          th {
            border-bottom: 1px solid #ddd;
            padding: 10px;
            background-color: #ddd;
          }
          td {
            vertical-align: baseline;
            border: 1px solid #ddd;
            padding: 10px 0;
            font-size: 12px;
            .shop_news {
              padding-left: 15px;
            }
            img {
              width: 60px;
              height: 60px;
            }
            p {
              padding: 10px 0;
            }
          }
          .border_right {
            border-right: 1px solid #ddd;
            text-align: left;
            padding: 0 10px;
          }
          .black {
            color: #333;
          }
          .space {
            padding: 10px;
            .payment-btn {
              height: 28px;
              padding: 0 10px;
              margin-left: 10px;
              color: #fff;
              border-radius: 4px;
              background-color: red;
              cursor: pointer;
            }
          }
          .bold {
            font-weight: 700;
          }
        }
      }
    }
  }
</style>