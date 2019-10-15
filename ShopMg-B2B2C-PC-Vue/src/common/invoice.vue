<template>
  <el-dialog title="发票信息" :visible="isShow" @close="isShow=false">
    <div class="alert">
      <div class="fapiao">
        <span
          v-for="(item,index) in invoiceData.invoice_type"
          :key="index"
          @click="fun(index,item.name)"
          :class="{bg:isbg0==index}"
        >{{item.name}}</span>
      </div>
      <div class="taitou">
        <p class="l">发票抬头：</p>
        <div class="l inp" ref="inp">
          <div
            class="value"
            v-for="(item,index) in invoiceData.raised_data"
            :key="item.id"
            @click="fun1(index,item.name)"
            :class="{bg:isbg1==index}"
          >
            <input
              type="text"
              :readonly="item.no_editable"
              v-model="item.name"
              placeholder="请填写公司发票抬头"
            />
            <span v-if="item.no_editable" @click="insert(index)">编辑</span>
            <span v-if="item.no_editable" @click="del(index,item.id)">删除</span>
            <span v-if="!item.no_editable" @click="keep(index)">保存</span>
          </div>
        </div>
        <p class="l" @click="add" v-show="news">新增单位发票</p>
      </div>
      <div class="content">
        <p class="l">发票内容：</p>
        <span
          class="l"
          v-for="(item,index) in invoiceData.invoice_content"
          :key="item.id"
          @click="fun2(index,item.name)"
          :class="{bg:isbg2==index}"
        >{{item.name}}</span>
      </div>
      <div class="btn">
        <button @click="save">开发票</button>
        <button @click="cancel">无需发票</button>
      </div>
    </div>
  </el-dialog>
</template>

<script>
export default {
  data() {
    return {
      isShow: false,
      news: true,
      invoiceData: {},
      isbg0: null,
      isbg1: null,
      isbg2: null,
      type_id: "",
      raised_id: "",
      raised_name: "",
      store_id: "",
      invoiceInit: {},
      invoiceTit: {},
      invoiceGroup: {},
      invoiceState: [],
      type_name: ""
    };
  },

  methods: {
    fun(index, name) {
      this.type_id = this.invoiceData.invoice_type[index].id;
      this.type_name = name;
      this.isbg0 = index;
    },
    fun1(index, name) {
      console.log(this.invoiceData.raised_data[index]);
      this.raised_id = this.invoiceData.raised_data[index].id;
      this.raised_name = name;
      this.isbg1 = index;
    },
    fun2(index, name) {
      this.content_id = this.invoiceData.invoice_content[index].id;
      this.content_name = name;
      this.isbg2 = index;
    },
    toggle(id) {
      this.store_id = id;
      this.isbg0 = null;
      this.isbg1 = null;
      this.isbg2 = null;
      let obj = Object.keys(this.invoiceInit);
      if (obj.length > 0 && this.invoiceInit[id]) {
        this.isbg0 = this.invoiceInit[id][0];
        this.isbg1 = this.invoiceInit[id][1];
        this.isbg2 = this.invoiceInit[id][2];
      }
      this.getInvoiceType();
      this.isShow = !this.isShow;
    },
    getInvoiceType() {
      this.HTTP(this.$httpConfig.getInvoiceTypeData, {}, "post").then(res => {
        this.invoiceData = res.data;
        console.log(this.invoiceData.raised_data);
        if (this.invoiceData.raised_data.length) {
          for (
            let index = 0;
            index < this.invoiceData.raised_data.length;
            index++
          ) {
            this.$set(this.invoiceData.raised_data[index], "no_editable", true);
          }
        }
      });
    },
    insert(index) {
      this.$set(this.invoiceData.raised_data[index], "no_editable", false);
    },
    del(index, id) {
      this.isShow = false;
      this.$confirm("您确定要删除该发票信息吗？", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        lockScroll: false,
        type: "warning",
        closeOnClickModal: false,
        center: true
      })
        .then(() => {
          this.HTTP(
            this.$httpConfig.invoicesAreRaisedDelete,
            {
              id: this.invoiceData.raised_data[index].id
            },
            "post"
          ).then(res => {
            if (this.invoiceData.raised_data[index].id == id) {
              this.invoiceData.raised_data.splice(index, 1);
              this.isbg1 = null;
              this.raised_id = "";
              this.raised_name = "";
            }
            this.isShow = true;
          });
        })
        .catch(() => {
          this.isShow = true;
        });
    },
    keep(index) {
      if (!this.invoiceData.raised_data[index].name) {
        alert("输入不能为空");
        return false;
      }
      if (this.invoiceData.raised_data[index].id) {
        //编辑
        this.HTTP(
          this.$httpConfig.invoicesAreRaisedSave,
          {
            id: this.invoiceData.raised_data[index].id,
            name: this.invoiceData.raised_data[index].name
          },
          "post"
        ).then(res => {
          this.$set(
            this.invoiceData.raised_data[index],
            "name",
            this.invoiceData.raised_data[index].name
          );
          this.$set(this.invoiceData.raised_data[index], "no_editable", true);
        });
      } else {
        //添加
        this.HTTP(
          this.$httpConfig.invoicesAreRaisedAdd,
          {
            name: this.invoiceData.raised_data[index].name
          },
          "post"
        ).then(res => {
          this.raised_id = res.data;
          let data = {
            id: res.data,
            name: this.invoiceData.raised_data[index].name,
            no_editable: true
          };
          for (
            let index = 0;
            index < this.invoiceData.raised_data.length;
            index++
          ) {
            if (this.invoiceData.raised_data[index].no_editable === false) {
              this.invoiceData.raised_data.splice(index, 1);
            }
          }
          this.invoiceData.raised_data.push(data);
        });
      }
      this.news = true;
    },
    save() {
      if (
        this.type_name == "" ||
        this.raised_name == "" ||
        this.content_name == ""
      ) {
        alert("请完善发票信息");
        return false;
      }
      this.getInvoiceId(this.content_id, this.type_id, this.raised_id);
    },
    cancel() {
      this.isShow = false;
      this.invoiceGroup[this.store_id] = {
        translate: 0
      };
      delete this.invoiceInit[this.store_id];
      this.invoiceOff();
      delete this.invoiceTit[this.store_id];
      this.type_name = "";
      this.raised_name = "";
      this.content_name = "";
    },
    add() {
      let data = {
        name: "",
        no_editable: false
      };
      this.invoiceData.raised_data.push(data);
      this.$nextTick(() => {
        this.$refs.inp.scrollTop = this.$refs.inp.scrollHeight;
      });
      this.news = false;
    },
    //获取发票id
    getInvoiceId(content_id, type_id, raised_id) {
      this.HTTP(
        this.$httpConfig.addOrderInvoice,
        {
          raised_id: parseInt(raised_id),
          content_id: parseInt(content_id),
          type_id: parseInt(type_id)
        },
        "post"
      )
        .then(res => {
          this.invoiceGroup[this.store_id] = {
            id: res.data,
            translate: 1
          };
          this.invoiceInit[this.store_id] = [
            this.isbg0,
            this.isbg1,
            this.isbg2
          ];
       
          this.invoiceTit[this.store_id] = [
            this.type_name,
            this.raised_name,
            this.content_name
          ];
         this.invoiceOff();
         
         this.$emit('receive-data', this.invoiceTit, this.invoiceInit, this.invoiceGroup);

          this.isShow = false;
        })
        .catch(e => console.log(e));
    },
    // 无需发票和修改显示
    invoiceOff() {
      let listKey = Object.keys(this.invoiceGroup);
      for (const i in listKey) {
        if (this.invoiceGroup[listKey[i]]) {
          this.invoiceState[listKey[i]] = this.invoiceGroup[
            listKey[i]
          ].translate;
        }
      }

      this.$emit('receive-state',  this.invoiceState);
    }
  }
};
</script>

<style lang= 'less' scoped>
.alert {
  margin: 20px 0 200px 25px;
  .fapiao {
    overflow: hidden;
    span {
      width: 96px;
      height: 30px;
      float: left;
      border: 1px solid #ccc;
      text-align: center;
      line-height: 30px;
      font-size: 12px;
      color: #646464;
      margin-right: 14px;
      cursor: pointer;
    }
  }
  .taitou {
    overflow: hidden;
    margin-top: 20px;
    margin-bottom: 22px;
    p:nth-of-type(1) {
      font-size: 12px;
      color: #646464;
      margin-top: 7px;
    }
    .inp {
      width: 376px;
      overflow: auto;
      overflow-x: hidden;
      max-height: 126px;
      min-height: 42px;
    }
    .top {
      width: 338px;
      height: 32px;
      line-height: 32px;
      border: 1px solid #ccc;
      padding-left: 13px;
      margin-bottom: 10px;
      float: left;
      cursor: pointer;
    }
    .value {
      width: 338px;
      height: 32px;
      border: 1px solid #ccc;
      padding-left: 13px;
      margin-bottom: 10px;
      float: left;
      cursor: pointer;
      input {
        width: 247px;
        height: 30px;
      }
      span {
        font-size: 12px;
        color: #43628e;
        padding-right: 8px;
      }
      span:hover {
        color: red;
      }
    }
    p:nth-of-type(2) {
      font-size: 12px;
      color: #4e75ac;
      margin-left: 60px;
      cursor: pointer;
    }
    p:nth-of-type(2):hover {
      color: red;
    }
    .alert {
      margin: 20px 0 200px 25px;
      .fapiao {
        overflow: hidden;
        span {
          width: 96px;
          height: 30px;
          float: left;
          border: 1px solid #ccc;
          text-align: center;
          line-height: 30px;
          font-size: 12px;
          color: #646464;
          margin-right: 14px;
          cursor: pointer;
        }
      }
      .taitou {
        overflow: hidden;
        margin-top: 20px;
        margin-bottom: 22px;
        p:nth-of-type(1) {
          font-size: 12px;
          color: #646464;
          margin-top: 7px;
        }
        .inp {
          width: 376px;
          overflow: auto;
          overflow-x: hidden;
          max-height: 126px;
          min-height: 42px;
        }
        .top {
          width: 338px;
          height: 32px;
          line-height: 32px;
          border: 1px solid #ccc;
          padding-left: 13px;
          margin-bottom: 10px;
          float: left;
          cursor: pointer;
        }
        .value {
          width: 338px;
          height: 32px;
          border: 1px solid #ccc;
          padding-left: 13px;
          margin-bottom: 10px;
          float: left;
          cursor: pointer;
          input {
            width: 247px;
            height: 30px;
          }
          span {
            font-size: 12px;
            color: #43628e;
            padding-right: 8px;
          }
          span:hover {
            color: red;
          }
        }
        p:nth-of-type(2) {
          font-size: 12px;
          color: #4e75ac;
          margin-left: 60px;
          cursor: pointer;
        }
        p:nth-of-type(2):hover {
          color: red;
        }
      }
      .content {
        overflow: hidden;
        p {
          font-size: 12px;
          color: #646464;
          margin-top: 7px;
        }
        span {
          width: 83px;
          height: 30px;
          float: left;
          border: 1px solid #ccc;
          margin-right: 15px;
          text-align: center;
          line-height: 30px;
          font-size: 12px;
          cursor: pointer;
        }
      }
      .btn {
        button {
          width: 70px;
          height: 30px;
          border: 1px solid #ccc;
          border-radius: 3px;
          margin-right: 8px;
          cursor: pointer;
        }
        button:nth-of-type(1) {
          color: #fff;
          background: #d29e24;
        }
        button:nth-of-type(2) {
          background: #eaeaea;
          cursor: pointer;
        }
      }
      .bg {
        background: url(../assets/img/bg.jpg) no-repeat bottom 0 right 0;
        border-color: red !important;
      }
    }
  }
  .content {
    overflow: hidden;
    p {
      font-size: 12px;
      color: #646464;
      margin-top: 7px;
    }
    span {
      width: 83px;
      height: 30px;
      float: left;
      border: 1px solid #ccc;
      margin-right: 15px;
      text-align: center;
      line-height: 30px;
      font-size: 12px;
      cursor: pointer;
    }
  }
  .btn {
    button {
      width: 70px;
      height: 30px;
      border: 1px solid #ccc;
      border-radius: 3px;
      margin-right: 8px;
      cursor: pointer;
    }
    button:nth-of-type(1) {
      color: #fff;
      background: #d29e24;
    }
    button:nth-of-type(2) {
      background: #eaeaea;
      cursor: pointer;
    }
  }
  .bg {
    background: url(../assets/img/bg.jpg) no-repeat bottom 0 right 0;
    border-color: red !important;
  }
}
</style>