/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

package Controller;

import java.io.File;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import org.apache.pdfbox.io.MemoryUsageSetting;
import org.apache.pdfbox.multipdf.PDFMergerUtility;

/**
 * @empresa Datecsa
 * @author Walter Paz Londoño
 * @fecha 07-feb-2017
 * @hora 9:54:16
 * --Descripción de funcionalidad
 */
public class ConsolidaPDF {
    
    private static ConsolidaPDF instance = null;
    private static LecturaPlano lecturaInstance = null;
    
    private ConsolidaPDF(){
        
    }
    
    public static ConsolidaPDF getInstance(){
        if(instance == null){
            instance = new ConsolidaPDF();
            lecturaInstance = LecturaPlano.getInstance();
        }
        return instance;
    }
    
    public void ContatenarPDF(String paramRutaArchivoPlano){
        try
        {
            
            EntityConsolidaPDF entidadPDF = lecturaInstance.realizarLecturaPlano(paramRutaArchivoPlano);
            if(unirPdfs(entidadPDF)){
                //Envia la eliminación del archivo plano
                List<String> listaArchivos = new ArrayList<>();
                listaArchivos.add(paramRutaArchivoPlano);
                BorrarArchivos(listaArchivos);
            }
            
            
        }catch(Exception ex){
            lecturaInstance.EscribirLog(ex.getMessage());
        }
        lecturaInstance.GenerarMensajes();
    }
    
    
    //public boolean unirPdfs(ArrayList<String> arrPdfs, String pathPdfDestino) {
    private boolean unirPdfs(EntityConsolidaPDF paramConsolidaPDF) {
        
        //Si la clase esta null, o no se encuentra el archivo plano para realizar la lectura
        if(paramConsolidaPDF == null){
            return false;
        }
        boolean salida = true;
        
        try {
            PDFMergerUtility mergerUtility = new PDFMergerUtility();
            
            mergerUtility.setDestinationFileName(paramConsolidaPDF.getRutaDestino());
            
            int contador = 0;
            for(String nombreArchivo : paramConsolidaPDF.getArchivosPDFConsolidar())
            {
                contador++;
                String rutaPdf = nombreArchivo;
                lecturaInstance.EscribirLog(" " + contador + ": " + rutaPdf);
                if(ValidarExistenciaArchivo(rutaPdf))
                {
                    mergerUtility.addSource(rutaPdf);
                }else{
                    throw new Exception("No existe el archivo en disco -> " +  rutaPdf);
                }
                
            }

            MemoryUsageSetting memoryUsageSetting = MemoryUsageSetting.setupTempFileOnly();
            mergerUtility.mergeDocuments(memoryUsageSetting);

            BorrarArchivos(paramConsolidaPDF.getArchivosPDFConsolidar());
            
            lecturaInstance.EscribirLog("Generado Exitosamente.");
            
            
        } catch (FileNotFoundException ex) {
            ex.printStackTrace();
            salida = false;
            lecturaInstance.EscribirLog("Error generando el archivo compilado de los pdfs.  " + ex.getMessage());
        } catch (IOException ex) {
            ex.printStackTrace();
            salida = false;
            lecturaInstance.EscribirLog("Error generando el archivo compilado de los pdfs.  " + ex.getMessage());
        } catch (Exception ex ){
            lecturaInstance.EscribirLog(ex.getMessage());
        }

        return salida;
    }
    
    private boolean ValidarExistenciaArchivo(String paramRutaArchivo){
        File f = new File(paramRutaArchivo);
        
        if(f.exists()){
            return true;
        }
        return false;
    }

    private boolean BorrarArchivos(List<String> listaArchivosBorrar) throws Exception
    {
        
        try{
            for(String nombreArchivo : listaArchivosBorrar){
                File f = new File(nombreArchivo);
                f.delete();
            }
            lecturaInstance.EscribirLog("Archivos borrados correctamente");
            return true;
        }catch(Exception ex){
            throw ex;
        }
    }
    
}
