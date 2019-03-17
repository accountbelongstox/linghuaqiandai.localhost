<a class="menu-toggler" id="menu-toggler" href="#">
	<span class="menu-text"></span>
</a>


<div class="sidebar" id="sidebar_wx">
	<ul class="nav nav-list">
	<li>
			<a href="/admin/weixin/admin/webchatAdd">
				<i class="icon-double-angle-right"></i>
				<span class="menu-text">添加公众账号</span>
			</a>
		</li>
	<?php if (is_array($data_wx_list['datalist'])): ?>
		<?php foreach ($data_wx_list['datalist'] as $key => $vals): ?>
		
			<li class="<?php 
				$tmp_Id_=$vals['WxWebchat']['Id'];
				if($tmp_Id_ == $this->viewVars['WC_wxId'] || $tmp_Id_ == $this->viewVars['data']['list']['WxWebchat']['Id']){
					echo 'active';
				} ?> open">
			<a href="" class="dropdown-toggle">
			<?= $this->Html->image($vals['WxWebchat']['FIcon'], array('fullBase' => true, 'width' => "30px", 'height' => "30px", 'alt' => "")); ?>
			<span class="menu-text"><?= $vals['WxWebchat']['FName'] ?></span>
			<b class="arrow icon-angle-down"></b>
			</a>
			<ul class="submenu">
						<li>
							<a href="javascript:;" onclick="window.location.href='<?= Router::url(array('controller' => "admin", 'action' => "webchatEdit", $vals['WxWebchat']['Id'])) ?>'">
								<i class="icon-double-angle-right"></i>
								编辑
							</a>
						</li>
						<li>
							<a href="/admin/weixin/admin/webchatDel/<?= $vals['WxWebchat']['Id'] ?>">
								<i class="icon-double-angle-right"></i>
								删除
							</a>
						</li>
						<li>
							<a href="javascript:;" onclick="window.location.href='<?= Router::url('/admin/wc/'.md5($vals['WxWebchat']['Id']).'/center'); ?>'">
								<i class="icon-double-angle-right"></i>
								管理
							</a>
						</li>
					</ul>
			</li>
			<?php endforeach ?>
		<?php endif ?>
	</ul>
	<?php
	/* 测试对比的微信ID
		echo "<pre>";
		print_r($this->viewVars['data']['list']['WxWebchat']['Id']);
		echo "</pre>";
		*/
	?>
</div>


<div class="sidebar" id="sidebar">
	<script type="text/javascript">
		try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
	</script>
	<div class="sidebar-shortcuts" id="sidebar-shortcuts">
		<!-- <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
					<button class="btn btn-success">
						<i class="icon-signal"></i>
					</button>

					<button class="btn btn-info">
						<i class="icon-pencil"></i>
					</button>

					<button class="btn btn-warning">
						<i class="icon-group"></i>
					</button>

					<button class="btn btn-danger">
						<i class="icon-cogs"></i>
					</button>
				</div> -->
		<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
			<span class="btn btn-success"></span>
			<span class="btn btn-info"></span>
			<span class="btn btn-warning"></span>
			<span class="btn btn-danger"></span>
		</div>
	</div><!-- #sidebar-shortcuts -->

	<ul class="nav nav-list">
		<?= $this->fetch('sidebar'); ?>
	</ul><!-- /.nav-list -->
	<div class="sidebar-collapse" id="sidebar-collapse">
		<i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
	</div>
	<script type="text/javascript">
		try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
	</script>
</div>

