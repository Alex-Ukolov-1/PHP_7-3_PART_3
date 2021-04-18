<?php
class RequestHelper
{

}

abstract class ProcessRequest
{
	abstract public function process (RequestHelper $req);
}

class MainProcess extends ProcessRequest
{
	public function process(RequestHelper $req)
	{
		print __Class__.":выполнение результататов"."<br/>";
	}
}

abstract class DecorateProcess extends ProcessRequest
{
	protected $processrequest;
	public function __construct(ProcessRequest $pr)
	{
		$this->processrequest=$pr;
	}
}
class LogRequest extends DecorateProcess
{
	public function process(RequestHelper$reg)
	{
		print __Class__.":регистрация запроса"."<br/>";
		$this->processrequest->process($reg);
	}
}

class AuthenticateRequest extends DecorateProcess
{
	public function process(RequestHelper $reg)
	{
		print __Class__.":аутентефикация запроса"."<br/>";
		$this->processrequest->process($reg);
	}
}

class StructureRequest extends DecorateProcess
{
	public function process(RequestHelper $reg)
	{
     print __Class__.":Формирование данных запроса"."<br/>";
     $this->processrequest->process($reg);
	}
}

$process=new AuthenticateRequest(new StructureRequest(new LogRequest(new MainProcess())));
$process->process(new RequestHelper());
?>