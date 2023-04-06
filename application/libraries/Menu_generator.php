<?php defined('BASEPATH') || exit('No direct script access allowed');

class Menu_generator
{
	protected $ci;
	protected $x; //Db Prefix
	protected $uri; //Current uri string
	protected $user_id;
	protected $is_admin;

	public function __construct()
	{
		$this->ci = &get_instance();

		$this->x = $this->ci->db->dbprefix;
		$this->uri = '/' . $this->ci->uri->uri_string() . '/';

		$this->ci->load->helper('app');
		//$this->ci->load->model('menus/users_model');
		$this->ci->load->library('users/auth');
		$this->user_id 	= $this->ci->auth->user_id();
		$this->is_admin = $this->ci->auth->is_admin();
	}


	public function build_menus($type = 1)
	{
		$auth = $this->get_auth_permission($this->user_id);
		if (!$auth) {
			$auth = array(NULL);
		}

		if ($type == 1) {
			$menu = $this->ci->db->select("t1.*")
				->from("{$this->x}menus as t1")
				->join("{$this->x}menus as t2", "t1.id = t2.parent_id", "left")
				//->join("{$this->x}menus as t3","t2.id = t3.parent_id","left")
				->where("t1.parent_id", 0)
				->where("t1.group_menu", $type)
				->where("t1.status", 1)
				->group_by("t1.id")
				->order_by("t1.order", "ASC")
				->get()
				->result();

			$html = "<ul class='sidebar-menu'>
							<li class='header'></li>
	                        <li class='" . check_class('dashboard', TRUE) . "'>
	                            <a href='" . site_url() . "'>
	                                <i class='fa fa-dashboard'></i> <span>Dashboard</span>
	                            </a>
	                        </li>";

			if (is_array($menu) && count($menu)) {
				foreach ($menu as $rw) {
					$id 		= $rw->id;
					$title 		= $rw->title;
					$link 		= $rw->link;
					$icon 		= $rw->icon;
					$target 	= $rw->target;
					$submenu = $this->ci->db->select("t1.*")
						->from("{$this->x}menus as t1")
						->where("t1.parent_id", $id)
						->where("t1.group_menu", $type)
						->where("t1.status", 1);
					if (!$this->is_admin) {
						$submenu = $submenu->where_in("t1.permission_id", $auth);
					}
					$submenu = $submenu->group_by("t1.id")
						->group_by("t1.id")
						->order_by("t1.order", "ASC")
						->get()
						->result();
					//Jump to end_for point
					if (count($submenu) == 0) {
						if ($link != "#") {
							if (!in_array($rw->permission_id, $auth) && $this->is_admin == FALSE) {
								goto end_for;
							}
							$active = "";
							if (strpos($this->uri, '/' . $link . '/') !== FALSE) {
								$active = "active";
							}
							$html .= "<li class='{$active}'><a href='" . ($link == '#' ? '#' : site_url($link)) . "' " . ($target == '_blank' ? "target='_blank'" : "") . ">
							<i class='{$icon}'></i> &nbsp;&nbsp;&nbsp;<span>" . ucwords($title) . "
							</span></a></li>";
						}
						goto end_for;
					}
					$active = "";
					foreach ($submenu as $sub) {
						if (strpos($this->uri, '/' . $sub->link . '/') !== FALSE) {
							$active = "active";
							break;
						}
					}
					$html .= "
            			  <li class='treeview {$active}'>
                      <a href='#'>
                        <i class='" . $icon . "'></i>
                        <span>" . ucwords($title) . "</span>
                        <span class='pull-right-container'>
						            	<i class='fa fa-angle-left pull-right'></i>
						          	</span>
                      </a>
                      <ul class='treeview-menu'>";

					//Make Sub Menu
					foreach ($submenu as $sub) {
						$subid 		= $sub->id;
						$subtitle 	= $sub->title;
						$sublink 	= $sub->link;
						$subicon 	= $sub->icon;
						$subtarget 	= $sub->target;
						$subtarget = "";
						if ($subtarget == '_blank') {
							$subtarget = "target='_blank'";
						}


						//Check current link
						if (strpos($this->uri, '/' . $sublink . '/') !== FALSE) {
							$active = "active";
						} else {
							$active = "";
						}
						$html .= "
						<li class='" . $active . "'>
							<a href='" . ($sublink == '#' ? '#' : site_url($sublink)) . "'" . " " . $subtarget . ">
							<i class='" . $subicon . "'></i>&nbsp;&nbsp;&nbsp;" . ucwords($subtitle) . "
							</a>
						</li>";
					}
					$html .= "
						</ul>
					</li>";

					//Jump Point
					end_for:;
					//END FOREACH MENU
				}
				$html .= "
					</ul>";
			}
		} else {
			//other menu
		}

		return $html;
	}

	public function show_menus($type = 1)
	{
		$html = '';
		$auth = '1';
		if (!$auth) {
			$auth = array(NULL);
		}
		if ($type == 1) {
			$menu = $this->ci->db->select("t1.*")
				->from("menus as t1")
				->join("menus as t2", "t1.id = t2.parent_id", "left")
				//->join("menus as t3","t2.id = t3.parent_id","left")
				->where("t1.parent_id", 0)
				->where("t1.group_menu", $type)
				->where("t1.status", 1)
				->group_by("t1.id")
				->order_by("t1.order", "ASC")
				->get()
				->result();

			$active_menu = (check_class('dashboard', TRUE)) ? 'active' : '';
			$html = '<ul class="navbar-nav flex-column" id="sideNavbar">
						<li class="nav-item">
							<a class="nav-link has-arrow ' . $active_menu . '" href="/">
								<i class="fa fa-dashboard me-2"></i> Dashboard
							</a>
						</li>
					';

			$active_sub = "";
			$show = "";
			if ($menu) {
				foreach ($menu as $n => $rw) {
					$id 		= $rw->id;
					$title 		= $rw->title;
					$link 		= $rw->link;
					$icon 		= $rw->icon;
					$target 	= $rw->target;

					if (strpos($this->uri, '/' . $link . '/') !== FALSE) {
						$active_sub = "active";
						$show = "show";
					}

					if ($link !== '#') {
						$html .= '<li class="nav-item">
								<a class="nav-link ' . $active_sub . '" href="' . $link . '" aria-expanded="false" aria-controls="navPages" target="' . $target . '">
									<i class="' . $icon . ' me-2">
									</i> ' . ucwords($title) . '
								</a>';
					} else {
						$html .= '<li class="nav-item">
								<a class="nav-link has-arrow" href="#" data-bs-toggle="collapse" data-bs-target="#navPages' . $id . '" aria-expanded="false" aria-controls="navPages">
									<i class="' . $icon . ' me-2">
									</i> ' . ucwords($title) . '
								</a>
								<div id="navPages' . $id . '" class="collapse" data-bs-parent="#sideNavbar">
									<ul class="nav flex-column">';

						$submenu = $this->ci->db->select("menus.*")->from("menus")
							->where(["menus.parent_id" => $id, "menus.group_menu" => $type, "menus.status" => 1])
							->group_by("menus.id")->order_by("menus.order", "ASC")->get()->result();

						foreach ($submenu as $sub) {
							$subid 		= $sub->id;
							$subtitle 	= $sub->title;
							$sublink 	= $sub->link;
							$subicon 	= $sub->icon;
							$subtarget 	= ($sub->target == '_blank') ? '_blank' : '';

							//Check current link
							if (strpos($this->uri, '/' . $sublink . '/') !== FALSE) {
								$active = "active";
							} else {
								$active = "";
							}
							$html .= '<li class="nav-item">
									<a class="nav-link ' . $active . '" href="' . site_url($sublink) . '" target="' . $subtarget . '">
										<i class="' . $subicon . '"></i> &nbsp ' . ucwords($subtitle) . '
									</a>
								</li>';
						}
						$html .= "</ul>
						</div>
					</li>";
					}
				}
				$html .= "
					</ul>";
			}
		} else {
			//other menu
		}
		return $html;
	}

	protected function get_auth_permission($user_id = 0)
	{
		$role_permissions = $this->ci->users_model->select("permissions.id_permission")
			->join("user_groups", "users.id_user = user_groups.id_user")
			->join("group_permissions", "user_groups.id_group = group_permissions.id_group")
			->join("permissions", "group_permissions.id_permission = permissions.id_permission")
			->where("users.id_user", $user_id)
			->find_all();

		$user_permissions = $this->ci->users_model->select("permissions.id_permission")
			->join("user_permissions", "users.id_user = user_permissions.id_user")
			->join("permissions", "user_permissions.id_permission = permissions.id_permission")
			->where("users.id_user", $user_id)
			->find_all();

		$merge = array();
		if ($role_permissions) {
			foreach ($role_permissions as $key => $rp) {
				if (!in_array($rp->id_permission, $merge)) {
					$merge[] = $rp->id_permission;
				}
			}
		}

		if ($user_permissions) {
			foreach ($user_permissions as $key => $up) {
				if (!in_array($up->id_permission, $merge)) {
					$merge[] = $up->id_permission;
				}
			}
		}

		return $merge;
	}
}
