<template>
  <div id="Net">
    <logo-component></logo-component>
    <div class="advance">
      <div class="center">
        <div class="logo l">
          <p class="iphone l">
            <span class="hot l">招商热线</span>
            <span class="shuzi l">{{$constant.tel}}</span>
          </p>
        </div>
        <div class="applicate r">
          <dl class="l">
            <dt class="l">
              <img src="../../assets/img/pen.png" />
            </dt>
            <dd class="l">
              <router-link to="agreement">商家入驻申请</router-link>
            </dd>
          </dl>
          <dl class="l">
            <dt class="l">
              <img src="../../assets/img/comput.png" />
            </dt>
            <dd class="l">商家管理中心</dd>
          </dl>
          <dl class="l">
            <dt class="l">
              <img src="../../assets/img/book.png" />
            </dt>
            <dd class="l">商家帮助指南</dd>
          </dl>
        </div>
      </div>
    </div>

    <div id="region">
      <div class="center">
        <p class="titleS">入驻流程</p>
        <p class="english">ADVANCE REGISTRATION PROGRESS</p>
        <div class="write">
          <dl class="l">
            <dt>
              <img src="../../assets/img/Parts1.png" />
            </dt>
            <dd>
              <p class="part-one">1.提交入驻资料</p>
              <p class="type">选择商店类型及品牌</p>
              <p class="info">填写入驻信息</p>
            </dd>
          </dl>
          <dl class="l">
            <dt>
              <img src="../../assets/img/Parts2.png" />
            </dt>
            <dd>
              <p class="part-two">2.商家等待审核</p>
              <p class="type">平台审核入驻信息</p>
              <p class="info">通知商家</p>
            </dd>
          </dl>
          <dl class="l">
            <dt>
              <img src="../../assets/img/Parts3.png" />
            </dt>
            <dd>
              <p class="part-three">3.完善店铺信息</p>
              <p class="type">登录商家后台</p>
              <p class="info">完善店铺信息</p>
            </dd>
          </dl>
          <dl class="l">
            <dt>
              <img src="../../assets/img/Parts4.png" />
            </dt>
            <dd>
              <p class="part-four">4.店铺上线</p>
              <p class="type">上传商品</p>
              <p class="info">发布销售</p>
            </dd>
          </dl>
        </div>
      </div>
    </div>
    <div id="progress">
      <div class="center">
        <div class="boxing l">
          <dl>
            <dt>
              <img src="../../assets/img/process.png" />
            </dt>
            <dd>
              <p class="enterZero">入驻流程</p>
              <p class="enterZeros">PROCESS</p>
            </dd>
          </dl>
        </div>
        <div class="success l">
          <div class="link">
            <p class="simily l">了解入驻要求</p>
            <p class="similies l">入驻标准</p>
            <p class="simily l">入驻申请</p>
            <p class="similies l">马上入驻</p>
            <p class="simily l">等待审核</p>
            <p class="similies l">查看审核结果</p>
            <p class="simily l">入驻成功</p>
          </div>
          <div class="tableList">
            <p class="chew">
              <span class="big">注册本站账号</span>
              <span class="small">点击本站右上方“免费注册”按钮进行注册，成为本站会员</span>
            </p>
            <p class="lianjie">
              <img src="../../assets/img/ruzhu.png" />
            </p>
            <p class="article">
              <span class="big">基本资料填写</span>
              <span class="small">进入“商家中心”，点击“立刻入住”，即可进行资料填写</span>
            </p>
            <p class="lianjie">
              <img src="../../assets/img/ruzhu.png" />
            </p>
            <p class="loadUp">
              <span class="big">资质证明上传</span>
              <span class="small">将营业执照彩色扫描件(或彩照形式)及盖公章的申请人身份证正反复印件上传</span>
            </p>
            <p class="lianjie">
              <img src="../../assets/img/ruzhu.png" />
            </p>
            <p class="application">
              <span class="big">等待审核</span>
              <span class="small">本站会在三个工作日内审核您的入驻</span>
            </p>
            <p class="lianjie">
              <img src="../../assets/img/ruzhu.png" />
            </p>
            <p class="agreement">
              <span class="big">签署协议</span>
              <span class="small">审核后即可在线签署《{{this.$constant.mainTitle}}入驻合同》</span>
            </p>
            <p class="lianjie">
              <img c src="../../assets/img/ruzhu.png" />
            </p>
            <p class="confirms">
              <span class="big">提交保证金</span>
              <span class="small">商家在活动上线前必须缴纳￥10000元商品质量和服务保证金</span>
              <span class="moreSmall">数码类目商家需缴纳￥50000(等其他类目</span>
              <span class="smallest">$8500,手续费自行负担)</span>
            </p>
          </div>
        </div>
      </div>
    </div>
    <div id="standard">
      <div class="center">
        <div class="boxing l">
          <dl>
            <dt>
              <img src="../../assets/img/stand_logo.png" />
            </dt>
            <dd>
              <p class="enterZero">入驻标准</p>
              <p class="enterZeros">STANDARD</p>
            </dd>
          </dl>
        </div>
        <div class="listTable l">
          <div class="company">
            <p class="companies">公司资质要求</p>
            <ul>
              <li class="change l">证件名称</li>
              <li class="changeLength l">资质要求</li>
              <li class="changes l">1.营业执照</li>
              <li class="changeLengthes l">
                必须具有法人资格，如为分支机构，不具有法人资格的需提供总公司营业执照，及其授权书；完成有效年检，复印件需要加盖公司印章。
                <a>查看样例>></a>
              </li>
              <li class="change l">2.税务登记证</li>
              <li class="changeLength l">
                国税地税均可；复印件需要盖公司印章
                <a>查看样例>></a>
              </li>
              <li class="change l">3.组织机构代码证</li>
              <li class="changeLength l">
                复印件需要盖公司印章
                <a>查看样例>></a>
              </li>
              <li class="change l lastBootom">4.法人身份证</li>
              <li class="changeLength l lastBootom">
                需要提供法人身份证扫面件或正反复印件，并加盖公司印章
                <a>查看样例>></a>
              </li>
            </ul>
          </div>
          <div class="comand">
            <p class="companies">品牌资质要求</p>
            <ul>
              <li class="change l">证件名称</li>
              <li class="changeLength l">资质要求</li>
              <li class="change l">1.商标注册证证</li>
              <li class="changeLength l">需要提供有效期内的商标注册证，仅接受R表</li>
              <li class="changeBig l">2.品牌授权书</li>
              <li class="changelengthest l">
                <p class="com">若品牌申请人为代理商，需要提供以下条件的品牌授权书</p>
                <p class="com">(1).需要授权在本站销售</p>
                <p class="com">(2).授权书需要注明权期限,落款</p>
                <p class="com">(3).若注册商是本人，需要提供商标注册人身份证正反面复印件</p>
                <p class="com">(4).需要确保授权链的完整，即申请入驻企业拿到的授权能够逐级逆推回品牌商</p>
              </li>
              <li class="changeable l">3.质检报告或者3C认证书</li>
              <li class="changeDistance l">
                每个品牌需要提供一份由权威机构质检出具的最近两年的质检报告或者有限期内的3C认证书
                <a>详情查看说明>></a>
              </li>
              <li class="change l lastBootom">4.报关单或者检验检疫证明</li>
              <li class="changeLength l lastBootom">若为进口产品，需提交一年内海关进口报关单和检验检疫合格证</li>
            </ul>
          </div>
          <div class="die_text">
            <p class="editor">
              <i>注：</i>商家具有一般纳税人和或者小额纳税人资质；注册资本50万以上
            </p>
            <p class="editor">我们接受各行业有一定知名度的品牌入驻，入驻企业须是品牌所有者，或者授权渠道商，并且所提供的是正品商品，价格足够竞争力。</p>
            <p class="editor">入驻商家经营类目需是一下的一种或几种 箱包 服饰 电器 办公</p>
            <p class="editor">入驻商家成立需大于1年，即营业执照有效期起始时间至提交入驻审核时间大于1年</p>
          </div>
        </div>
      </div>
    </div>
    <div id="process">
      <div class="center">
        <div class="boxing l">
          <dl>
            <dt>
              <img src="../../assets/img/process_logo.png" />
            </dt>
            <dd>
              <p class="enterZero">合作细节</p>
              <p class="enterZeros">PROCESS</p>
            </dd>
          </dl>
        </div>
        <div class="success l">
          <div class="fare">
            <p class="companies">收费标准</p>
            <p class="time">*本站于2015年2月1日起，邀请部分品牌商家体验平台合作，暂时不收佣金。</p>
            <p class="ratio">*本站有权根据市场情况及自身经营情况调整佣金比例，但调整需要至少三十天通知商家。</p>
          </div>
          <div class="day">
            <p class="companies">15天无理由退货服务</p>
            <h2>一、15天无理由退货</h2>
            <p
              class="wear"
            >*本站郑重承诺：如商品未经使用或穿着，商品及外包装保持出售时的原状，商品吊牌及配件齐全，将享受15天无理由退货服务，即你对商品不满意，在不影响二次销售的情况下，可在收货后15天内无理由退货，退回运费由你自行承担，退回金额将在商家确认收货一个工作日退回至你本站账户。</p>
            <p class="warm">
              <i>温馨提示：</i>以下商品均不享受15天无理由退货服务
            </p>
            <p class="beside">1.任何非本站出售商品</p>
            <p class="beside">2.申请退货日期距商品签收日期超过7日</p>
            <p
              class="besides"
            >3.任何因非正常使用，保管或卖家个人原因造成商品损坏，包括但不限于自行修改尺寸，洗涤皮具表面刮花，打油，刺绣，水洗，碰酸，碱，油或触硬物，雨天穿着，长时间穿着等</p>
            <p class="beside">4.未经网上申请，自行寄回至本站或供应商仓库</p>
            <p class="beside">5.使用运费到付,平邮或将商品寄回正确地址</p>
            <p class="beside">6.鉴于食品安全问题，食品类商品不支持无理由退货</p>
            <p class="beside">7.海外购某些特殊情况不办退货的，但仍可与商家的协商</p>
            <p>二.退货条款</p>
            <p class="beside">(一).15天无理由退货产生的运费由买家承担</p>
            <p
              class="besides"
            >(二).由于商品问题导致的退货，本站将提供运费补贴，同省补贴不高于10元，非同省不超过20元，特定地区不超过25元(特定地区指：新疆 西藏 内蒙古 宁夏 青海)。</p>
            <p class="beside">(三).本站是限时抢购模式，商品在线时间不超过7天，不支持换货</p>
          </div>
          <div class="backGoods">
            <p class="companies">退货流程</p>
            <p class="beside">第一步：申请退货：进入“个人中心—我的订单”找到对应的订单，点击“售后”，填写及上传相关的信息提交退货申请。</p>
            <p class="beside">第二步：本站审核：退货申请提交后，本站将对退货理由.图片凭证进行审核。</p>
            <p class="beside">第三步：寄回商品：审核通过后，根据页面的地址退货商品，并填写有效的退货物流物流单号(部分退货无需此操作)</p>
            <p class="beside">第四步：供应商签收，供应商签收后，同意退款申请</p>
            <p class="beside">第五步：退款完成：退款款项将在1个工作日内打款至{{this.$constant.mainTitle}}账户。</p>
          </div>
        </div>
      </div>
    </div>
    <foot-com></foot-com>
  </div>
</template>

<script>
export default {
  data() {
    return {};
  },
  methods: {
    enter() {
      this.$router.push("/custom");
    },
    getTitle() {
      return "招商入住";
    },
    goTo() {
      this.$router.push("/home");
    }
  }
};
</script>

<style lang="less" scoped>
.center {
  width: 1200px;
  height: 100%;
  margin: 0 auto;
}

.l {
  float: left;
}

.r {
  float: right;
}

.advance {
  width: 100%;
  height: 104px;
  .center {
    height: 104px;
    .Gongpin {
      width: 186px;
      height: 104px;
      img {
        margin-top: 20px;
        padding-right: 20px;
        height: 60px;
        border-right: 1px solid #dedede;
      }
    }
    .iphone {
      width: 240px;
      height: 104px;
      .hot {
        display: inline-block;
        width: 70px;
        height: 104px;
        line-height: 104px;
        font-size: 13px;
        margin-left: 20px;
      }
      .shuzi {
        display: inline-block;
        height: 104px;
        line-height: 104px;
        font-size: 16px;
        color: #d53738;
        font-weight: 500;
      }
    }
    .applicate {
      width: 485px;
      height: 104px;
      /*line-height: 104px;*/
      dl {
        width: 124px;
        height: 54px;
        margin-top: 50px;
        margin-right: 30px;
        dt {
          margin-right: 3px;
        }
        dd {
          font-size: 14px;
          cursor: pointer;
        }
      }
    }
  }
}
#region {
  width: 100%;
  height: 454px;
  .center {
    height: 454px;
    .titleS {
      width: 100%;
      height: 44px;
      line-height: 44px;
      text-align: center;
      font-size: 25px;
      color: #010101;
      margin-top: 68px;
    }
    .english {
      width: 100%;
      height: 28px;
      line-height: 28px;
      font-size: 14px;
      color: #929292;
      text-align: center;
    }
    .write {
      width: 100%;
      height: 280px;
      dl {
        width: 170px;
        height: 280px;
        margin: 0px 65px;
        margin-top: 60px;
        dt {
          text-align: center;
        }
        dd {
          height: 165px;
          width: 100%;
          text-align: center;
          .part-one {
            width: 100%;
            height: 32px;
            line-height: 32px;
            color: #91c601;
            font-size: 17px;
          }
          .part-two {
            width: 100%;
            height: 32px;
            line-height: 32px;
            color: #01c698;
            font-size: 17px;
          }
          .part-three {
            width: 100%;
            height: 32px;
            line-height: 32px;
            color: #0191c6;
            font-size: 17px;
          }
          .part-four {
            width: 100%;
            height: 32px;
            line-height: 32px;
            color: #01c636;
            font-size: 17px;
          }
          .type {
            font-size: 14px;
            color: #a0a0a0;
          }
          .info {
            font-size: 14px;
            color: #a0a0a0;
          }
        }
      }
    }
  }
}

#progress {
  width: 100%;
  height: 1036px;
  background: #d2f8ea;
  .center {
    height: 1036px;
    .boxing {
      width: 198px;
      height: 198px;
      margin-top: 50px;
      background: url(../../assets/img/bg-ju.png) no-repeat;
      dl {
        width: 148px;
        height: 148px;
        margin-top: 50px;
        margin-left: 50px;
        dt {
          width: 38px;
          height: 38px;
          margin-left: 30px;
        }
        dd {
          width: 86px;
          height: 60px;
          margin-top: 3px;
          .enterZero {
            width: 100%;
            height: 24px;
            line-height: 24px;
            font-size: 16px;
            color: #ffffff;
            margin-left: 17px;
          }
          .enterZeros {
            width: 100%;
            height: 24px;
            line-height: 24px;
            font-size: 9px;
            color: #ffffff;
            margin-left: 21px;
          }
        }
      }
    }
    .success {
      width: 1000px;
      height: 936px;
      margin-top: 50px;
      background: #ffffff;
      .link {
        width: 910px;
        height: 164px;
        margin-top: 38px;
        margin-left: 90px;
        .simily {
          width: 124px;
          height: 124px;
          line-height: 124px;
          background: url(../../assets/img/shape.png) no-repeat;
          text-align: center;
          font-size: 16px;
          color: #4bd4a0;
        }
        .similies {
          width: 100px;
          height: 74px;
          margin-top: 50px;
          margin-left: 20px;
          font-size: 16px;
          color: #4bd4a0;
        }
      }
      .tableList {
        width: 1000px;
        height: 705px;
        margin-top: 30px;
        .chew {
          width: 452px;
          height: 58px;
          background: #35d198;
          border-radius: 10px;
          margin-left: 274px;
          .big {
            display: block;
            width: 100%;
            height: 28px;
            line-height: 28px;
            text-align: center;
            font-size: 14px;
            color: #ffffff;
          }
          .small {
            display: block;
            width: 100%;
            height: 20px;
            line-height: 20px;
            text-align: center;
            font-size: 11px;
            color: #ffffff;
          }
        }
        .article {
          width: 452px;
          height: 58px;
          background: #35d198;
          border-radius: 10px;
          margin-left: 274px;
          .big {
            display: block;
            width: 100%;
            height: 28px;
            line-height: 28px;
            text-align: center;
            font-size: 14px;
            color: #ffffff;
          }
          .small {
            display: block;
            width: 100%;
            height: 20px;
            line-height: 20px;
            text-align: center;
            font-size: 11px;
            color: #ffffff;
          }
        }
        .loadUp {
          width: 552px;
          height: 58px;
          background: #35d198;
          border-radius: 10px;
          margin-left: 226px;
          .big {
            display: block;
            width: 100%;
            height: 28px;
            line-height: 28px;
            text-align: center;
            font-size: 14px;
            color: #ffffff;
          }
          .small {
            display: block;
            width: 100%;
            height: 20px;
            line-height: 20px;
            text-align: center;
            font-size: 11px;
            color: #ffffff;
          }
        }
        .application {
          width: 310px;
          height: 58px;
          background: #35d198;
          border-radius: 10px;
          margin-left: 346px;
          .big {
            display: block;
            width: 100%;
            height: 28px;
            line-height: 28px;
            text-align: center;
            font-size: 14px;
            color: #ffffff;
          }
          .small {
            display: block;
            width: 100%;
            height: 20px;
            line-height: 20px;
            text-align: center;
            font-size: 11px;
            color: #ffffff;
          }
        }
        .agreement {
          width: 310px;
          height: 58px;
          background: #35d198;
          border-radius: 10px;
          margin-left: 346px;
          .big {
            display: block;
            width: 100%;
            height: 28px;
            line-height: 28px;
            text-align: center;
            font-size: 14px;
            color: #ffffff;
          }
          .small {
            display: block;
            width: 100%;
            height: 20px;
            line-height: 20px;
            text-align: center;
            font-size: 11px;
            color: #ffffff;
          }
        }
        .confirms {
          width: 442px;
          height: 98px;
          background: #35d198;
          border-radius: 10px;
          margin-left: 279px;
          .big {
            display: block;
            width: 100%;
            height: 28px;
            line-height: 28px;
            text-align: center;
            font-size: 14px;
            color: #ffffff;
          }
          .small {
            display: block;
            width: 100%;
            height: 20px;
            line-height: 20px;
            text-align: center;
            font-size: 11px;
            color: #ffffff;
          }
          .moreSmall {
            display: block;
            width: 100%;
            height: 20px;
            line-height: 20px;
            text-align: center;
            font-size: 11px;
            color: #ffffff;
          }
          .smallest {
            display: block;
            width: 100%;
            height: 20px;
            line-height: 20px;
            text-align: center;
            font-size: 11px;
            color: #ffffff;
          }
        }
        .lianjie {
          width: 100%;
          height: 43px;
          margin-left: 487px;
        }
      }
    }
  }
}

#standard {
  width: 100%;
  height: 1136px;
  background: #9de3fc;
  .center {
    height: 1136px;
    .boxing {
      width: 198px;
      height: 198px;
      margin-top: 50px;
      background: url(../../assets/img/stand_bg.png) no-repeat;
      dl {
        width: 148px;
        height: 148px;
        margin-top: 50px;
        margin-left: 50px;
        dt {
          width: 38px;
          height: 38px;
          margin-left: 30px;
        }
        dd {
          width: 86px;
          height: 60px;
          margin-top: 3px;
          .enterZero {
            width: 100%;
            height: 24px;
            line-height: 24px;
            font-size: 16px;
            color: #ffffff;
            margin-left: 17px;
          }
          .enterZeros {
            width: 100%;
            height: 24px;
            line-height: 24px;
            font-size: 9px;
            color: #ffffff;
            margin-left: 16px;
          }
        }
      }
    }
    .listTable {
      width: 1000px;
      height: 1037px;
      background: #ffffff;
      margin-top: 50px;
      padding-left: 46px;
      .company {
        width: 100%;
        height: 328px;
        .companies {
          width: 100%;
          height: 24px;
          line-height: 24px;
          border-left: 5px solid #0191c6;
          margin-top: 48px;
          padding-left: 10px;
          color: #000000;
        }
        ul {
          width: 900px;
          height: 236px;
          margin-top: 20px;
          .change {
            width: 318px;
            height: 38px;
            line-height: 38px;
            border-left: 1px solid #e4e4e4;
            border-top: 1px solid #e4e4e4;
            padding-left: 40px;
          }
          .changeLength {
            width: 580px;
            height: 38px;
            line-height: 38px;
            border-left: 1px solid #e4e4e4;
            border-top: 1px solid #e4e4e4;
            border-right: 1px solid #e4e4e4;
            padding-left: 40px;
            a {
              color: red;
            }
          }
          .changes {
            width: 318px;
            height: 72px;
            line-height: 72px;
            border-left: 1px solid #e4e4e4;
            border-top: 1px solid #e4e4e4;
            padding-left: 40px;
          }
          .changeLengthes {
            width: 580px;
            height: 72px;
            border-left: 1px solid #e4e4e4;
            border-top: 1px solid #e4e4e4;
            border-right: 1px solid #e4e4e4;
            padding-left: 40px;
            padding-top: 15px;
            a {
              color: red;
            }
          }
          .changeable {
            width: 318px;
            height: 72px;
            line-height: 72px;
            border-left: 1px solid #e4e4e4;
            border-top: 1px solid #e4e4e4;
            padding-left: 40px;
          }
          .changeBig {
            width: 318px;
            height: 176px;
            line-height: 72px;
            border-left: 1px solid #e4e4e4;
            border-top: 1px solid #e4e4e4;
            padding-left: 40px;
            padding-top: 50px;
          }
          .changelengthest {
            width: 580px;
            height: 176px;
            border-left: 1px solid #e4e4e4;
            border-top: 1px solid #e4e4e4;
            border-right: 1px solid #e4e4e4;
            padding-left: 40px;
            padding-top: 15px;
            a {
              color: red;
            }
            .com {
              height: 30px;
              line-height: 30px;
            }
          }
          .changeDistance {
            width: 580px;
            height: 72px;
            border-left: 1px solid #e4e4e4;
            border-top: 1px solid #e4e4e4;
            border-right: 1px solid #e4e4e4;
            padding-left: 40px;
            padding-top: 15px;
            a {
              color: red;
            }
          }
          .lastBootom {
            border-bottom: 1px solid #e4e4e4;
          }
        }
      }
      .comand {
        width: 100%;
        height: 440px;
        .companies {
          width: 100%;
          height: 24px;
          line-height: 24px;
          border-left: 5px solid #0191c6;
          margin-top: 48px;
          padding-left: 10px;
          color: #000000;
        }
        ul {
          width: 900px;
          height: 236px;
          margin-top: 20px;
          .change {
            width: 318px;
            height: 38px;
            line-height: 38px;
            border-left: 1px solid #e4e4e4;
            border-top: 1px solid #e4e4e4;
            padding-left: 40px;
          }
          .changeLength {
            width: 580px;
            height: 38px;
            line-height: 38px;
            border-left: 1px solid #e4e4e4;
            border-top: 1px solid #e4e4e4;
            border-right: 1px solid #e4e4e4;
            padding-left: 40px;
            a {
              color: red;
            }
          }
          .changes {
            width: 318px;
            height: 72px;
            line-height: 72px;
            border-left: 1px solid #e4e4e4;
            border-top: 1px solid #e4e4e4;
            padding-left: 40px;
          }
          .changeLengthes {
            width: 580px;
            height: 72px;
            border-left: 1px solid #e4e4e4;
            border-top: 1px solid #e4e4e4;
            border-right: 1px solid #e4e4e4;
            padding-left: 40px;
            padding-top: 15px;
            a {
              color: red;
            }
          }
          .changeable {
            width: 318px;
            height: 72px;
            line-height: 72px;
            border-left: 1px solid #e4e4e4;
            border-top: 1px solid #e4e4e4;
            padding-left: 40px;
          }
          .changeBig {
            width: 318px;
            height: 176px;
            line-height: 72px;
            border-left: 1px solid #e4e4e4;
            border-top: 1px solid #e4e4e4;
            padding-left: 40px;
            padding-top: 50px;
          }
          .changelengthest {
            width: 580px;
            height: 176px;
            border-left: 1px solid #e4e4e4;
            border-top: 1px solid #e4e4e4;
            border-right: 1px solid #e4e4e4;
            padding-left: 40px;
            padding-top: 15px;
            a {
              color: red;
            }
            .com {
              height: 30px;
              line-height: 30px;
            }
          }
          .changeDistance {
            width: 580px;
            height: 72px;
            border-left: 1px solid #e4e4e4;
            border-top: 1px solid #e4e4e4;
            border-right: 1px solid #e4e4e4;
            padding-left: 40px;
            padding-top: 15px;
            a {
              color: red;
            }
          }
          .lastBootom {
            border-bottom: 1px solid #e4e4e4;
          }
        }
      }
      .die_text {
        width: 100%;
        height: 186px;
        .editor {
          height: 32px;
          line-height: 32px;
          i {
            color: #0191c6;
          }
        }
      }
    }
  }
}

#process {
  width: 100%;
  height: 1318px;
  background: #ffefec;
  .center {
    height: 1328px;
    .boxing {
      width: 198px;
      height: 198px;
      margin-top: 50px;
      background: url(../../assets/img/process_bg.png) no-repeat;
      dl {
        width: 148px;
        height: 148px;
        margin-top: 50px;
        margin-left: 50px;
        dt {
          width: 38px;
          height: 38px;
          margin-left: 28px;
        }
        dd {
          width: 86px;
          height: 60px;
          margin-top: 3px;
          .enterZero {
            width: 100%;
            height: 24px;
            line-height: 24px;
            font-size: 16px;
            color: #ffffff;
            margin-left: 17px;
          }
          .enterZeros {
            width: 100%;
            height: 24px;
            line-height: 24px;
            font-size: 9px;
            color: #ffffff;
            margin-left: 20px;
          }
        }
      }
    }
    .success {
      width: 1000px;
      height: 1200px;
      background: #ffffff;
      margin-top: 50px;
      padding-left: 50px;
      .fare {
        width: 100%;
        height: 124px;
        margin-top: 40px;
        border-bottom: 1px solid #e4e4e4;
        .companies {
          width: 900px;
          height: 24px;
          line-height: 24px;
          border-left: 5px solid #ff907e;
          padding-left: 14px;
        }
        .time {
          width: 900px;
          height: 32px;
          line-height: 32px;
        }
        .ratio {
          width: 900px;
          height: 32px;
          line-height: 32px;
        }
      }
      .day {
        width: 900px;
        height: 622px;
        border-bottom: 1px solid #e4e4e4;
        margin-top: 20px;
        .companies {
          width: 900px;
          height: 24px;
          line-height: 24px;
          border-left: 5px solid #ff907e;
          padding-left: 14px;
        }
        h2 {
          width: 100%;
          height: 28px;
          line-height: 28px;
        }
        .wear {
          width: 900px;
          height: 86px;
          margin-top: 10px;
        }
        .warm {
          width: 900px;
          height: 38px;
          line-height: 38px;
          i {
            color: #ff907e;
          }
        }
        .beside {
          width: 900px;
          height: 32px;
          line-height: 32px;
        }
        .besides {
          width: 900px;
          height: 50px;
        }
      }
      .backGoods {
        width: 100%;
        height: 238px;
        border-bottom: 1px solid #e4e4e4;
        margin-top: 20px;
        .companies {
          width: 900px;
          height: 24px;
          line-height: 24px;
          border-left: 5px solid #ff907e;
          padding-left: 14px;
          margin-top: 10px;
        }
        .beside {
          width: 900px;
          height: 32px;
          line-height: 32px;
        }
      }
    }
  }
}
</style>