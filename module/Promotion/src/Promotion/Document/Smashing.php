<?php
namespace Promotion\Document;

use Core\AbstractDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(
 * collection="wx_promotion_smashing"
 * )
 */
class Smashing extends AbstractDocument
{
	/**
	 * @ODM\Id
	 */
	protected $id;
	
	/**
	 * @ODM\Field(type="string")
	 */
	protected $label;
	
	/**
	 * @ODM\Field(type="string")
	 */
	protected $awardInfo;
	
	/**
	 * @ODM\Field(type="string")
	 */
	protected $synopsis;
	
	/**
	 * @ODM\Field(type="string")
	 */
	protected $explain;
	
	/**
	 * @ODM\Field(type="string")
	 */
	protected $lotteryReply;
	
	/**
	 * @ODM\Field(type="hash")
	 */
	protected $prizes;
	
	/**
	 * @ODM\Field(type="float")
	 */
	protected $odds;
	
	/**
	 * @ODM\Field(type="int")
	 */
	protected $drawLimit;
	
	/**
	 * @ODM\Field(type="int")
	 */
	protected $drawLimitDaily;
	
	/**
	 * @ODM\Field(type="boolean")
	 */
	protected $isActive = true;
	
	/**
	 * @ODM\Field(type="date")
	 */
	protected $startTime;
	
	/**
	 * @ODM\Field(type="date")
	 */
	protected $endTime;
	
	
	public function exchangeArray($data)
	{
		if(isset($data['label'])){
			$this->label = $data['label'];
		}
		
		if(isset($data['awardInfo'])){
			$this->awardInfo = $data['awardInfo'];
		}
		
		if(isset($data['synopsis'])){
			$this->synopsis = $data['synopsis'];
		}
		
		if(isset($data['explain'])){
			$this->explain = $data['explain'];
		}
		
		if(isset($data['lotteryReply'])){
			$this->lotteryReply = $data['lotteryReply'];
		}
		
		if(isset($data['prizes'])){
			$this->prizes = $data['prizes'];
		}
		
		if(isset($data['odds'])){
			$this->odds = $data['odds'];
		}
		
		if(isset($data['drawLimit'])){
			$this->drawLimit = $data['drawLimit'];
		}
		
		if(isset($data['drawLimitDaily'])){
			$this->drawLimitDaily = $data['drawLimitDaily'];
		}
		
		if(isset($data['startTime'])){
			$this->startTime = new \DateTime($data['startTime']);
		}
		
		if(isset($data['endTime'])){
			$this->endTime = new \DateTime($data['endTime']);
		}
	}
	
	public function getArrayCopy()
	{
		return array(
			'id' => $this->id,
			'label' => $this->label,
			'awardInfo' => $this->awardInfo,
			'synopsis' => $this->synopsis,
			'explain' => $this->explain,
			'lotteryReply' => $this->lotteryReply,
			'prizes' => $this->prizes,
			'odds' => $this->odds,
			'drawLimit' => $this->drawLimit,
			'drawLimitDaily' => $this->drawLimitDaily,
			'startTime' => $this->startTime,
			'endTime' => $this->endTime,
		);
	}
	
	public function isActive(){
		if($this->isActive) {
			$startTime = $this->startTime->getTimestamp();
			$endTime = $this->endTime->getTimestamp();
			$now = time();
			if($now < $startTime) {
				return 'inactive';
			}else if($now > $endTime) {
				return 'ending';
			}
			return 'active';
		}else {
			return 'ending';
		}
	}
}