/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

package Controller;

import java.util.List;

/**
 * @empresa Datecsa
 * @author Walter Paz Londoño
 * @fecha 06-feb-2017
 * @hora 16:32:19
 * --Descripción de funcionalidad
 */
public class EntityConsolidaPDF {
    
    private String rutaDestino;
    
    private List<String> archivosPDFConsolidar;

    /**
     * @return the rutaDestino
     */
    public String getRutaDestino() {
        return rutaDestino;
    }

    /**
     * @param rutaDestino the rutaDestino to set
     */
    public void setRutaDestino(String rutaDestino) {
        this.rutaDestino = rutaDestino;
    }

    /**
     * @return the archivosPDFConsolidar
     */
    public List<String> getArchivosPDFConsolidar() {
        return archivosPDFConsolidar;
    }

    /**
     * @param archivosPDFConsolidar the archivosPDFConsolidar to set
     */
    public void setArchivosPDFConsolidar(List<String> archivosPDFConsolidar) {
        this.archivosPDFConsolidar = archivosPDFConsolidar;
    }
    
}
