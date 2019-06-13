<?php
/*
surendra gupta
25-Aug-2016
*/


require_once 'contactcampaign.civix.php';


function contactcampaign_civicrm_tabset($tabsetName, &$tabs, $context) {

  if ($tabsetName == 'civicrm/contact/view') {
          $contactId = $context['contact_id'];
         $url = 'civicrm/campaignlist';
      //set the id of the selected contact to session
       $session = CRM_Core_Session::singleton();
       $session->set('SelUser',$contactId);


     //SET params
      $params = array(
          'contact_id' => $contactId,
      );

      // Making Api Calls
       @ $contactCampaigns = civicrm_api3('PCP', 'get', $params);

      //get the number of pcp created by user
       @$thereIsCampaign = $contactCampaigns['count'];

    $tabs[] = array( 'id'    => 'contactCampaignTab',
        'url'   => $url,
        'qs' => 'cid=%%$contactId%%',
        'title' => 'Contact Campaign',
        'weight' => 300,
        'count'=> $thereIsCampaign,
    );
  }
}



/**
 * Implements Hook Civicrm dashboard
 */
function contactcampaign_civicrm_dashboard( $contactID, &$contentPlacement )
{

    //get the id of the selected contact from the session
    $session = CRM_Core_Session::singleton();
    $selContact = $session->get('SelUser');


     $currentTab =  CRM_Utils_System::currentPath();

    if ($currentTab == 'civicrm/contact/civicrm/campaignlist'){


    $contentPlacement = 3;

    try {
        //define Params
       $params = array(
            'contact_id' => $selContact,
            'api.ContributionSoft.get' => [
                'pcp_id' => '$value.id'
            ],
            'api.ContributionPage.get' => [
                'id' => '$value.page_id'
            ]
        );

               // Making Api Calls
               $campaigns = civicrm_api3('PCP', 'get', $params);
        if ($campaigns['count']){

            $campaignList = '<table class="selector" >';
            $campaignList .= '<tr class="columnheader"><th>Title</th><th>Status</th><th>Contribution Page / Event</th><th>Number of Contributions</th>
                                     <th>Amount Raised</th><th>Target Amount</th>
                                      <th></th></tr>';

            foreach ($campaigns['values'] as $campaign) {
                $pcpStatus = CRM_Contribute_PseudoConstant::pcpStatus();

                // page id i.e contribution page or event
                $PageId = $campaign['page_id'];

                // page type  i.e contribution page or event
                $page_type = $campaign['page_type'];

                //link to edit page
                $editAction = CRM_Utils_System::url('civicrm/pcp/info', 'action=update&reset=1&id=' . $PageId . '&context=dashboard');

                if ($page_type == 'contribute') {
                    $pageUrl = CRM_Utils_System::url('civicrm/' . $page_type . '/transact', 'reset=1&id=' . $PageId);
                } else {
                    $pageUrl = CRM_Utils_System::url('civicrm/' . $page_type . '/register', 'reset=1&id=' . $PageId);
                }

                //PCP title
                $title = $campaign['title'];

                //add status
                $status = $pcpStatus[$campaign['status_id']];

                #check/get number of contribution for campaign
                $thereIs_contributions = $campaign["api.ContributionSoft.get"]['count'];

                if($thereIs_contributions){
                    //contributions
                    $contributions = $campaign["api.ContributionSoft.get"]['values'];

                    //amount raised
                    $amountRaised = array_sum(array_column($contributions, 'amount'));
                    //raisedAmount
                    $raisedAmount = CRM_Utils_Money::format($amountRaised, $campaign['currency']);

                    //targetAmount
                    $targetAmount   = CRM_Utils_Money::format($campaign['goal_amount'], $campaign['currency']);

                    //no of contributions
                    $noContributions = $thereIs_contributions;
                }

                $campaignList .= '<tr class="odd">';
                $campaignList .= '<td><a href="' . $pageUrl . '">' . $title . '</a></td>';
                $campaignList .= '<td>' . $status . '</td>';
                $campaignList .= '<td>'. $page_type.'</td>';
                $campaignList .= '<td>'. $noContributions.'</td>';
                $campaignList .=  '<td>'.$raisedAmount.'</td>';
                $campaignList .=  '<td>'.$targetAmount.'</td>';
                $campaignList .= '<td><a href="' . $editAction . '"> Edit </a></td>';

                $campaignList .= '</tr>';

            };

            $campaignList .= '</table>';


        }else{
            //User created zero campaign page. :-)
            $message = "";
            $message.= '<div ><p style="background-color: beige;padding: 2px 5px; border: solid 1px orange;">Personal Campaign Page to view</p></div>';
            $campaignList = $message;
        }


    } catch (CiviCRM_API3_Exception $e) {
        $error = $e->getMessage();
    }



    return array(
        ''=>$campaignList,
    );

    }

}

/**
 * Config
 */
function contactcampaign_civicrm_config(&$config) {
  _contactcampaign_civix_civicrm_config($config);
}

/**
 * xmlMenu().
 */
function contactcampaign_civicrm_xmlMenu(&$files) {
  _contactcampaign_civix_civicrm_xmlMenu($files);
}

/**
 * Install
 */
function contactcampaign_civicrm_install() {
  _contactcampaign_civix_civicrm_install();
}














function contactcampaign_civicrm_uninstall() {
  _contactcampaign_civix_civicrm_uninstall();
}


function contactcampaign_civicrm_enable() {
  _contactcampaign_civix_civicrm_enable();
}


function contactcampaign_civicrm_disable() {
  _contactcampaign_civix_civicrm_disable();
}

/**
 * civicrm upgrade

 */
function contactcampaign_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _contactcampaign_civix_civicrm_upgrade($op, $queue);
}

/**
 * civicrm managed().
 */
function contactcampaign_civicrm_managed(&$entities) {
  _contactcampaign_civix_civicrm_managed($entities);
}

/**
 * civicrm caseTypes

 */
function contactcampaign_civicrm_caseTypes(&$caseTypes) {
  _contactcampaign_civix_civicrm_caseTypes($caseTypes);
}

/**
 * angularModules
 *
 * list of Angular modules.
 *

 */
function contactcampaign_civicrm_angularModules(&$angularModules) {
_contactcampaign_civix_civicrm_angularModules($angularModules);
}

/**
 * alterSettingsFolders
  
 */
function contactcampaign_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _contactcampaign_civix_civicrm_alterSettingsFolders($metaDataFolders);
}