<?php

namespace cervezasBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use cervezasBundle\Entity\Cervezas;
use cervezasBundle\Form\CervezasType;
use Symfony\Component\HttpFoundation\Request;

class CervezaController extends Controller{
    public function crearCervezaAction($nombre,$pais, $poblacion, $tipo){

      //Nuevo Objeto de tipo Cervezas
      $cerveza = new Cervezas();
      $cerveza->setNombre($nombre);
      $cerveza->setPais($pais);
      $cerveza->setPoblacion($poblacion);
      $cerveza->setTipo($tipo);
      $cerveza->setImportacion(true);
      $cerveza->setTamaño(20);
      $cerveza->setFechaAlmacen(\DateTime::createFromFormat("d/m/Y","24/12/2018"));
      $cerveza->setCantidad(20);
      $cerveza->setFoto('.png');

      //Doctrine
      $mangeDoct=$this->getDoctrine()->getManager();
      $mangeDoct->persist($cerveza);
      $mangeDoct->flush();
      return $this->render('cervezasBundle:Cervezas:crearCerveza.html.twig',array("cervezas"=>$cerveza));
    }

    public function nuevoFormularioAction(){
      $form= $this->createForm(CervezasType::class);
      return $this->render('cervezasBundle:Cervezas:index.html.twig', array("form"=>$form->createView() ));
    }


}
