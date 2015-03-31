<?php

namespace Controller\Admin\Member;
class Edit extends \Controller\Admin\Member
{
    public $data;
    public $path = array('member', 'member.edit');

    protected $_tpl = 'admin/member/edit';

    public function get($id)
    {
        if ($id) {
            $this->result = \Model\Member::find($id);
        } else {
            $this->result = array();

        }

    }

    public function post($id)
    {
        $data = $_POST;
        if ($id) {
            $member = \Model\Member::find($id);
            $member->set($data);
            $member->save();
        }else{
            $member = new \Model\Member();
            $member->set($data);
            $member->save();
        }
        redirect('/admin/member');

    }
}