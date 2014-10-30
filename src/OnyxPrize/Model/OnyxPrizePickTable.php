<?php
namespace OnyxPrize\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
/**
 * OnyxPrizePickTable model
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
class OnyxPrizePickTable
{

    public $tableGateway = null;

    /**
     * build the model
     */
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * Return all data
     */
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    /**
     * retrieve object by id
     *
     * @id The primary key of the object
     */
    public function getById($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
        	return false;
        }
        return $row;
    }

    /**
     * retrieve object by id
     *
     * @id The primary key of the object
     */
    public function save(OnyxPrizePick $onyxprizepick)
    {
        $data = array(
        	'id' => $onyxprizepick->id,
        	'win_time' => $onyxprizepick->win_time,
        	'onyx_prize_id' => $onyxprizepick->onyx_prize_id,
        	'claimed' => $onyxprizepick->claimed,
        	'updatedon' => $onyxprizepick->updatedon,
        	'postdate' => $onyxprizepick->postdate,

        );
        $id = (int)$onyxprizepick->id;
        if ($id == 0) {
        	$data['postdate'] = date('Y-m-d H:i:s');
        	$id = $this->tableGateway->insert($data);
        	$onyxprizepick->id = $id;
        	return $id;
        } else {
        	if ($this->getById($id)) {
        		$this->tableGateway->update($data, array('id' => $id));
        	} else {
        		throw new \Exception('OnyxPrizePick id does not exist');
        	}
        }
    }

    /**
     * Delete onject by id
     *
     * @id The primary key of the object
     */
    public function delete($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
    
    public function isThereAPrizeForMe(){
        $sql = $this->tableGateway->getSql();
        
        $updateStm = "UPDATE `onyx_prize_pick`
                    SET `claimed` = '1'
                    WHERE
                            `win_time` < '".date('Y-m-d H:i:s')."'
                    AND `claimed` = '0'
                    LIMIT 1";
        
        $dbAdapter = $sql->getAdapter();
        
        $statement = $dbAdapter->createStatement($updateStm); 
        
        return $statement->execute(); 
        
    }
    

    /**
     * check if there are prizes assign for today
     */
    public function checkIfTodayPicked($onyxPrizeId)
    {
        $sql = $this->tableGateway->getSql();
        $select = $sql->select();
        $select->where->lessThan('win_time', date('Y-m-d 23:59:59'));
        $select->where->greaterThan('win_time', date('Y-m-d 0:00:00'));
        $select->where(array('onyx_prize_id' => $onyxPrizeId));

        //echo $sql->getSqlstringForSqlObject($select); die ; 
        
        
        $resultSet = $this->tableGateway->selectWith($select);
        
        if (count($resultSet) < 1) {
            return false;
        }
        return true;
    }


}

?>