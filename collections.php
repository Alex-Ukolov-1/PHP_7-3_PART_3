<?php
class User
{};

class UserList
{
	private $list=[];

	public function __construct(User ...$user)
	{
      $this->list=$user;
	}

	public function add(User $user)
	{
		$this->list[]=$user;
	}

	public function all():array
	{
		return $this->list;
	}
}
$userlist=new UserList(new User(),new User());
$userlist->add(new User());
$userlist->add(new User());
$userlist->add(new User());
print_r($userlist->all());
?>