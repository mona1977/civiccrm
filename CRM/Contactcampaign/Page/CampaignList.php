<?php

/*
surendra gupta
25-Aug-2016
*/


require_once 'CRM/Core/Page.php';

class CRM_Contactcampaign_Page_CampaignList extends CRM_Core_Page {
  public function run() {

    CRM_Utils_System::setTitle(ts('CampaignList'));
    $this->assign('currentTime', date('Y-m-d H:i:s'));
    parent::run();
  }
}
