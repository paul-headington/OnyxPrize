<?php
namespace OnyxPrize\Model;

/**
 * OnyxPrizeSetting model
 *
 * This is a class generated with Paul's Zend MVC Model Generator.
 *
 * @author Paul Headington
 * @createdOn
 * @license Copyright (c) 2014, Paul HeadingtonAll rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 * 1. Redistributions of source code must retain the above copyright
 * notice, this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright
 * notice, this list of conditions and the following disclaimer in the
 * documentation and/or other materials provided with the distribution.
 * 3. All advertising materials mentioning features or use of this software
 * must display the following acknowledgement:
 * This product includes software developed by the <organization>.
 * 4. Neither the name of the <organization> nor the
 * names of its contributors may be used to endorse or promote products
 * derived from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY Paul Headington 'AS IS' AND ANY
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL Paul Headington BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */
class OnyxPrizeSetting
{

    use \GetSet\SetterGetter;

    public $id = null;

    public $limit_period = null;

    public $amount_per_hour = 0;

    public $hour_weight = null;

    public $updatedon = null;

    public $updatedby = 0;

    public $postdate = null;

    const filter = null;

    protected $validation = array(
        'id' => array(
            'required' => false,
            'name' => 'id',
            'validators' => array(
                array(
                    'name' => 'not_empty'
                ),
                array(
                    'name' => 'string_length',
                    'options' => array(
                        'min' => 1
                    )
                )
            )
        ),
        'limit_period' => array(
            'required' => false,
            'name' => 'limit_period',
            'validators' => array(
                array(
                    'name' => 'not_empty'
                ),
                array(
                    'name' => 'string_length',
                    'options' => array(
                        'min' => 3
                    )
                )
            )
        ),
        'amount_per_hour' => array(
            'required' => false,
            'name' => 'amount_per_hour',
            'validators' => array(
                array(
                    'name' => 'not_empty'
                ),
                array(
                    'name' => 'string_length',
                    'options' => array(
                        'min' => 1
                    )
                )
            )
        ),
        'hour_weight' => array(
            'required' => false,
            'name' => 'hour_weight',
            'validators' => array(
                array(
                    'name' => 'not_empty'
                ),
                array(
                    'name' => 'string_length',
                    'options' => array(
                        'min' => 3
                    )
                )
            )
        ),
        'updatedon' => array(
            'required' => false,
            'name' => 'updatedon',
            'validators' => array(

            )
        ),
        'updatedby' => array(
            'required' => false,
            'name' => 'updatedby',
            'validators' => array(
                array(
                    'name' => 'not_empty'
                ),
                array(
                    'name' => 'string_length',
                    'options' => array(
                        'min' => 1
                    )
                )
            )
        ),
        'postdate' => array(
            'required' => false,
            'name' => 'postdate',
            'validators' => array(

            )
        )
    );

    /**
     * build the model
     */
    public function __construct()
    {
    }

    /**
     * Validation selector
     */
    public function getValidation()
    {
        return $this->validation;
    }

    /**
     * set array data to object
     */
    public function exchangeArray($data)
    {
        $this->id		= (isset($data["id"])) ? $data["id"] : null;
        $this->limit_period		= (isset($data["limit_period"])) ? $data["limit_period"] : null;
        $this->amount_per_hour		= (isset($data["amount_per_hour"])) ? $data["amount_per_hour"] : null;
        $this->hour_weight		= (isset($data["hour_weight"])) ? $data["hour_weight"] : null;
        $this->updatedon		= (isset($data["updatedon"])) ? $data["updatedon"] : null;
        $this->updatedby		= (isset($data["updatedby"])) ? $data["updatedby"] : null;
        $this->postdate		= (isset($data["postdate"])) ? $data["postdate"] : null;
    }


}

?>
