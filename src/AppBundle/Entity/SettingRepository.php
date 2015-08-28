<?php
/**
 * Created by PhpStorm.
 * User: Hana Lee
 * Date: 2015-08-28
 * Time: 20:15
 */

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class SettingRepository extends EntityRepository
{
	public function findOneWithArrayResult()
	{
		$setting = $this->getEntityManager()->createQueryBuilder()
			->select("s")->from("AppBundle:Setting", "s")
			->getQuery()->getArrayResult();

		if (!$setting) {
			$setting = array();
		}

		return $setting;
	}

	/**
	 * @param array $params
	 */
	public function update(array $params)
	{
		$em = $this->getEntityManager();

		$settingId = $params["id"];

		$setting = $em->getRepository("AppBundle:Setting")->find($settingId);
		$setting->setSentenceCount($params["sentenceCount"]);
		$setting->setFirstType($params["firstType"]);
		$setting->setSecondType($params["secondType"]);
		$setting->setThirdType($params["thirdType"]);
		$setting->setFourthType($params["fourthType"]);
		$setting->setModified(1);

		$em->flush();
	}
}