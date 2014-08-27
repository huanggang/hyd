##好易贷Drupal安装设置


- 如果没有搭建邮件服务，需要找到modules\user\user.module中的 **user\_register\_submit** 方法，注释掉里面所有对于方法 **\_user\_mail\_notify** 的调用，否则注册会因发送邮件失败而延时
- 模块设置admin/modules
	- Enable easyloan模块
	- Disable RDF module, 防止Slideshow图片HTML格式发生混乱
- Theme设置admin/appearance
	- 选择‘好易贷’主题，设置为Enable and set default
- 设置maintenance页面
	- 在站点的配置文件中设置**$conf['maintenance_theme'] = 'hyd';**(默认配置default.settings.php)
	- 在admin/config/development/maintenance设置维护页面的message，**注意**：从维护状态恢复之前需要清空缓存
- admin/config/system/site-information
	- Site Name 设置为 **清远好易贷**
	- Slogan 设置为 **中国最大最安全的B2C（公司对个人）网络金融投资平台**
	- E-mail address 设置为 **huang.gang@gmail.com**
	- Error pages
		- 403 page **user**
		- 404 page **notfound**
- admin/config/regional/language
	- Add language添加**中文**
	- 将**简体中文**设置为**Default**
- admin/config/people/accounts
	- Anonymous users的Name设置为 **匿名用户**
	- Administrator role选择 **disabled**
	- Registration and cancellation
		- Who can register accounts选择**Visitors**,否则注册会失败
		- 勾掉Require e-mail verification when a visitor creates an account
	- Personalization中，
		- 勾选 **Enable user pictures**.
		- Picture directory设置为**pictures**
		- Default picture设置为**sites/all/themes/hyd/images/default-avatar-96.png**
		- Picture display style为**<none\>**
		- Picture upload dimensions为**96x96**
		- Picture upload file size为**30KB**
		- Picture guidelines为**上传头像简易使用96x96大小**
- admin/config/people/captcha
	- Form protection
		- **user\_login**和**user\_register\_form**都选择**image**
		- 取消所有打勾项
- admin/config/people/captcha/captcha/after
	- Captcha protected forms
		- user_login form
			- 选择enable
			- 具体内容参考下图酌情设置
			![](http://localhost/img/easyloan-settings-captcha-after.png)
	- Persistence 选择 **Always add a challenge** 
- admin/config/people/captcha/image_captcha
	- Code settings设置为 **aAbBCdEeFfGHhijKLMmNPQRrSTtWXYZ23456789**
	- Code Length设置为4
	- Font设置参考下图
	![](http://localhost/img/easyloan-settings-captcha-image.png)

