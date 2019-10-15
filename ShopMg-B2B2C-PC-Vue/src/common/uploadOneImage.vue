<template>
	<div v-loading="loading">
		<el-upload :headers = "headers" class="avatar-uploader" :action="uploadIMGURL" :data="uploadData"  :show-file-list="false" :on-success="handleAvatarSuccess" :before-upload="beforeUploade">
			<img v-if="dialogImageUrl" :src="dialogImageUrl" class="avatar">
			<i v-else class="el-icon-plus avatar-uploader-icon"></i>
		</el-upload>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				loading: false,
				dialogImageUrl: '',
				dialogVisible: false,
				uploadIMGURL: this.$httpConfig.uploadPicture,
				headers:{
                    "Content-Type": "multipart/form-data"
				},
                uploadData: {
                    sessionToken: "",
                    imageToken: ""
                },
			}
		},
		mounted() {
            this.HTTP(this.$httpConfig.getGoodsImgCofig, {}, 'post').then(res => {
                let data = res.data;
                this.imageConf = data.config;
                this.imageToken = data.token;
                this.sToken = data.s_token;
            });
        },
		methods: {
			// 上传之前
			beforeUploade(file) {
                this.uploadData.sessionToken = this.sToken;
                this.uploadData.imageToken = this.imageToken;
                const isLt2M = file.size / 1024 / 1024 < 3;
                if (!isLt2M) {
                    this.$message.error("上传头像图片大小不能超过 2MB!");
                }
                return isLt2M;
			},
			// 上传成功
			handleAvatarSuccess(response, file, fileList) {
				console.log(response)
				this.$message.success(response.message);

				if(response.status == 0) {
					let length = fileList.length;
					let i = 0;
					for(i; i < length; i++) {
						if(fileList[i].name === file.name) {
							fileList.splice(i, 1);
						}
					}
				} else {
					this.dialogImageUrl = response.data;
					this.loading = false;
					this.sendData();
					console.log(this.dialogImageUrl)

				}
			},
			// 发送数据给父组件
			sendData() {
				console.log(this.dialogImageUrl)
				this.$emit('sendImageData', this.dialogImageUrl);
			}
		},
	}
</script>

<style>
	.avatar-uploader .el-upload {
		border: 1px dashed #d9d9d9;
		border-radius: 6px;
		cursor: pointer;
		position: relative;
		overflow: hidden;
	}
	
	.avatar-uploader .el-upload:hover {
		border-color: #409EFF;
	}
	
	.avatar-uploader-icon {
		font-size: 28px;
		color: #8c939d;
		width: 178px;
		height: 178px;
		line-height: 178px;
		text-align: center;
	}
	
	.avatar {
		width: 178px;
		height: 178px;
		display: block;
	}
</style>