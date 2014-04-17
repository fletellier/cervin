<?php
namespace Collection;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\Persistence\ObjectManager;
use TestsCervin\Doctrine;

use PHPUnit_Framework_TestCase;

/**
 * Classe permettant d'effectuer des tests unitaires sur l'entité des éléments
 */
class ElementsTest extends Doctrine
{
	
	public function setUp()
	{
		parent::setUp();
	}
	
	public function tearDown()
	{
		parent::tearDown();
	}
	
	private function constructeurTypeElement($type) {
		$type_element = new Entity\TypeElement('Exemple de type d\'element', $type);
		$this->assertEquals($type_element->__get('nom'), 'Exemple de type d\'element');
		$this->assertEquals($type_element->__get('type'), $type);
		$this->assertEmpty($type_element->__get('champs'));
		$this->em->persist($type_element);
		$this->em->flush();
		$bdd = $this->em->getRepository('Collection\Entity\TypeElement')->findOneBy(array('nom'=>'Exemple de type d\'element', 'type'=>$type));
		$this->assertNotNull($bdd);
		$this->em->remove($bdd);
		$this->em->flush();
	}	
	
	/**
	 * @expectedException		InvalidArgumentException
	 */
	public function testConstructeurTypeElementError() {
		$this->constructeurTypeElement('Type Interdit');
	}
	
	public function testConstructeurTypeElementOK() {
		$this->constructeurTypeElement('artefact');
		$this->constructeurTypeElement('media');
	}
	
	private function constructeurChamp($format) {
		$type_element = new Entity\TypeElement('Exemple de type d\'element', 'artefact');
		$champ_artefact = new Entity\Champ('Exemple de label', $type_element, $format);
		$this->assertEquals($champ_artefact->__get('label'), 'Exemple de label');
		$this->assertEquals($champ_artefact->__get('type_element'), $type_element);
		$this->assertEquals($champ_artefact->__get('type_element')->__get('type'), 'artefact');
		$this->assertEquals($champ_artefact->__get('format'), $format);
		
		$this->em->persist($type_element);
		$this->em->persist($champ_artefact);
		$this->em->flush();
		$bdd_type_element = $this->em->getRepository('Collection\Entity\TypeElement')->findOneBy(array('nom'=>'Exemple de type d\'element', 'type'=>'artefact'));
		$bdd_champ = $this->em->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'Exemple de label', 'type_element'=>$bdd_type_element));
		$this->assertNotNull($bdd_type_element);
		$this->assertNotNull($bdd_champ);
		$this->em->remove($bdd_champ);
		$this->em->flush();
		$this->em->remove($bdd_type_element);
		$this->em->flush();
	}
	
	/**
	 * @expectedException		InvalidArgumentException
	 */
	public function testConstructeurChampError() {
		$this->constructeurChamp('Format Interdit');
	}
	
	/**
	 * @expectedException		InvalidArgumentException
	 */
	public function testConstructeurChampError2() {
		$this->constructeurChamp(34);
	}
	
	public function testConstructeurChampOK() {
		$this->constructeurChamp('texte');
		$this->constructeurChamp('date');
		$this->constructeurChamp('fichier');
		$this->constructeurChamp('nombre');
		$this->constructeurChamp('url');
	}
	
	private function constructeurArtefact($type) {
		$type_element = new Entity\TypeElement('Exemple de type d\'element', $type);
		$artefact = new Entity\Artefact('Exemple d\'artefact', $type_element);
		$this->assertEquals($artefact->__get('titre'), 'Exemple d\'artefact');
		$this->assertEquals($artefact->__get('type_element'), $type_element);
		$this->assertNull($artefact->__get('datas'));
		
		$this->em->persist($type_element);
		$this->em->persist($artefact);
		$this->em->flush();
		$bdd_type_element = $this->em->getRepository('Collection\Entity\TypeElement')->findOneBy(array('nom'=>'Exemple de type d\'element', 'type'=>$type));
		$bdd_artefact = $this->em->getRepository('Collection\Entity\Artefact')->findOneBy(array('titre'=>'Exemple d\'artefact', 'type_element'=>$bdd_type_element));
		$this->assertNotNull($bdd_artefact);
		$this->assertNotNull($bdd_type_element);
		$this->em->remove($bdd_artefact);
		$this->em->flush();
		$this->em->remove($bdd_type_element);
		$this->em->flush();
	}
	
	/**
	 * @expectedException		InvalidArgumentException
	 */
	public function testConstructeurArtefactError() {
		$this->constructeurArtefact('media');
	}
	
	/**
	 * @expectedException		InvalidArgumentException
	 */
	public function testConstructeurArtefactError2() {
		$this->constructeurArtefact('Type Interdit');
	}
	
	/**
	 * @expectedException		InvalidArgumentException
	 */
	public function testConstructeurArtefactError3() {
		$this->constructeurArtefact(3);
	}
	
	public function testConstructeurArtefactOK() {
		$this->constructeurArtefact('artefact');
	}
	
	private function constructeurMedia($type) {
		$type_element = new Entity\TypeElement('Exemple de type d\'element', $type);
		$media = new Entity\Media('Exemple de média', $type_element);
		$this->assertEquals($media->__get('titre'), 'Exemple de média');
		$this->assertEquals($media->__get('type_element'), $type_element);
		$this->assertNull($media->__get('datas'));
		
		$this->em->persist($type_element);
		$this->em->persist($media);
		$this->em->flush();
		$bdd_type_element = $this->em->getRepository('Collection\Entity\TypeElement')->findOneBy(array('nom'=>'Exemple de type d\'element', 'type'=>$type));
		$bdd_media = $this->em->getRepository('Collection\Entity\Media')->findOneBy(array('titre'=>'Exemple de média', 'type_element'=>$bdd_type_element));
		$this->assertNotNull($bdd_media);
		$this->assertNotNull($bdd_type_element);
		$this->em->remove($bdd_media);
		$this->em->flush();
		$this->em->remove($bdd_type_element);
		$this->em->flush();
	}
	
	/**
	 * @expectedException		InvalidArgumentException
	 */
	public function testConstructeurMediaError() {
		$this->constructeurMedia('artefact');
	}
	
	/**
	 * @expectedException		InvalidArgumentException
	 */
	public function testConstructeurMediaError2() {
		$this->constructeurMedia('Type Interdit');
	}
	
	/**
	 * @expectedException		InvalidArgumentException
	 */
	public function testConstructeurMediaError3() {
		$this->constructeurMedia(3);
	}
	
	public function testConstructeurMediaOK() {
		$this->constructeurMedia('media');
	}
	
}
