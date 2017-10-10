<?php /* Originating Release: November 2014 */

namespace RightNow\Models;

use RightNow\Api;

/**
 * Methods for accessing surveys
 */
class Survey extends Base
{
    /**
     * Build a URL for accessing the specified survey
     *
     * @param int $surveyID The survey ID to use to build the link
     * @return string Survey link corresponding to surveyID
     */
    public function buildSurveyURL($surveyID)
    {
        return Api::build_survey_url($surveyID);
    }
}
