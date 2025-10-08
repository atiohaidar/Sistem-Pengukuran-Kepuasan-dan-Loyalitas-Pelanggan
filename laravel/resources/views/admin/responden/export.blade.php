
<html>

  
    
                      <table>
                      
                        <tr>
                          <td colspan="8">Download pada : <?php echo date('Y-m-d'); ?></td>
                          
                        </tr>
                        <tr>
                          <td colspan="8"><b>DATA RESPONDEN</b></td>
                          
                        </tr>
                        
                        <tr>
                          <td rowspan="2"><b>NO</b></td>
                          <td rowspan="2"><b>ID Responden</b></td>
                          <td width="25" rowspan="2"><b>Nama Bisnis</b></td>
                          <td width="15" rowspan="2"><b>Email</b></td>
                          <td width="15" rowspan="2"><b>WA</b></td>
                          <td width="15" rowspan="2"><b>Jenis kelamin</b></td>
                          <td width="15" rowspan="2"><b>Usia</b></td>
                          <td width="15" rowspan="2"><b>Pekerjaan</b></td>
                          <td width="15" rowspan="2"><b>Domisili</b></td>
                          <td width="50" colspan="26"><b>Nilai Harapan</b></td>
                          <td width="50" colspan="26"><b>Nilai Persepsi</b></td>
                        </tr>
                        <tr>
                          <td width="5"><b>R1</b></td>
                          <td width="5"><b>R2</b></td>
                          <td width="5"><b>R3</b></td>
                          <td width="5"><b>R4</b></td>
                          <td width="5"><b>R5</b></td>
                          <td width="5"><b>R6</b></td>
                          <td width="5"><b>R7</b></td>
                          <td width="5"><b>A1</b></td>
                          <td width="5"><b>A2</b></td>
                          <td width="5"><b>A3</b></td>
                          <td width="5"><b>A4</b></td>
                          <td width="5"><b>T1</b></td>
                          <td width="5"><b>T2</b></td>
                          <td width="5"><b>T3</b></td>
                          <td width="5"><b>T4</b></td>
                          <td width="5"><b>T5</b></td>
                          <td width="5"><b>T6</b></td>
                          <td width="5"><b>E1</b></td>
                          <td width="5"><b>E2</b></td>
                          <td width="5"><b>E3</b></td>
                          <td width="5"><b>E4</b></td>
                          <td width="5"><b>E5</b></td>
                          <td width="5"><b>RS1</b></td>
                          <td width="5"><b>RS2</b></td>
                          <td width="5"><b>AP1</b></td>
                          <td width="5"><b>AP2</b></td>

                          <td width="5"><b>R1</b></td>
                          <td width="5"><b>R2</b></td>
                          <td width="5"><b>R3</b></td>
                          <td width="5"><b>R4</b></td>
                          <td width="5"><b>R5</b></td>
                          <td width="5"><b>R6</b></td>
                          <td width="5"><b>R7</b></td>
                          <td width="5"><b>A1</b></td>
                          <td width="5"><b>A2</b></td>
                          <td width="5"><b>A3</b></td>
                          <td width="5"><b>A4</b></td>
                          <td width="5"><b>T1</b></td>
                          <td width="5"><b>T2</b></td>
                          <td width="5"><b>T3</b></td>
                          <td width="5"><b>T4</b></td>
                          <td width="5"><b>T5</b></td>
                          <td width="5"><b>T6</b></td>
                          <td width="5"><b>E1</b></td>
                          <td width="5"><b>E2</b></td>
                          <td width="5"><b>E3</b></td>
                          <td width="5"><b>E4</b></td>
                          <td width="5"><b>E5</b></td>
                          <td width="5"><b>RS1</b></td>
                          <td width="5"><b>RS2</b></td>
                          <td width="5"><b>AP1</b></td>
                          <td width="5"><b>AP2</b></td>

                        </tr>
                        @foreach ($datas as $item)
                        <tr>
                          <td width="5">{{ $loop->iteration }}</td>
                          <td width="5">{{ $item->id_responden }}</td>
                          <td width="5">{{ $item->nama_bisnis }}</td>
                          <td width="5">{{ $item->email }}</td>
                          <td width="5">{{ $item->whatsapp }}</td>
                          <td width="5">{{ $item->jk }}</td>

                          <td width="5">{{ $item->usia }}</td>
                          <td width="5">{{ $item->pekerjaan }}</td>
                          <td width="5">{{ $item->title }}</td>
                          <td width="5">{{ $item->kepentingan_r1 }}</td>
                          <td width="5">{{ $item->kepentingan_r2 }}</td>
                          <td width="5">{{ $item->kepentingan_r3 }}</td>
                          <td width="5">{{ $item->kepentingan_r4 }}</td>
                          <td width="5">{{ $item->kepentingan_r5 }}</td>
                          <td width="5">{{ $item->kepentingan_r6 }}</td>
                          <td width="5">{{ $item->kepentingan_r7 }}</td>
                          <td width="5">{{ $item->kepentingan_a1 }}</td>
                          <td width="5">{{ $item->kepentingan_a2 }}</td>
                          <td width="5">{{ $item->kepentingan_a3 }}</td>
                          <td width="5">{{ $item->kepentingan_a4 }}</td>
                          <td width="5">{{ $item->kepentingan_t1 }}</td>
                          <td width="5">{{ $item->kepentingan_t2 }}</td>
                          <td width="5">{{ $item->kepentingan_t3 }}</td>
                          <td width="5">{{ $item->kepentingan_t4 }}</td>
                          <td width="5">{{ $item->kepentingan_t5 }}</td>
                          <td width="5">{{ $item->kepentingan_t6 }}</td>
                          <td width="5">{{ $item->kepentingan_e1 }}</td>
                          <td width="5">{{ $item->kepentingan_e2 }}</td>
                          <td width="5">{{ $item->kepentingan_e3 }}</td>
                          <td width="5">{{ $item->kepentingan_e4 }}</td>
                          <td width="5">{{ $item->kepentingan_e5 }}</td>
                          <td width="5">{{ $item->kepentingan_rs1 }}</td>
                          <td width="5">{{ $item->kepentingan_rs2 }}</td>
                          <td width="5">{{ $item->kepentingan_ap1 }}</td>
                          <td width="5">{{ $item->kepentingan_ap2 }}</td>
                          


                          <td width="5">{{ $item->persepsi_r1 }}</td>
                          <td width="5">{{ $item->persepsi_r2 }}</td>

                          <td width="5">{{ $item->persepsi_r3 }}</td>
                          <td width="5">{{ $item->persepsi_r4 }}</td>
                          <td width="5">{{ $item->persepsi_r5 }}</td>
                          <td width="5">{{ $item->persepsi_r6 }}</td>
                          <td width="5">{{ $item->persepsi_r7 }}</td>
                          
                          <td width="5">{{ $item->persepsi_a1 }}</td>
                          <td width="5">{{ $item->persepsi_a2 }}</td>
                          <td width="5">{{ $item->persepsi_a3 }}</td>
                          <td width="5">{{ $item->persepsi_a4 }}</td>
                          <td width="5">{{ $item->persepsi_t1 }}</td>
                          <td width="5">{{ $item->persepsi_t2 }}</td>
                          <td width="5">{{ $item->persepsi_t3 }}</td>
                          <td width="5">{{ $item->persepsi_t4 }}</td>
                          <td width="5">{{ $item->persepsi_t5 }}</td>
                          <td width="5">{{ $item->persepsi_t6 }}</td>
                          <td width="5">{{ $item->persepsi_e1 }}</td>
                          <td width="5">{{ $item->persepsi_e2 }}</td>
                          <td width="5">{{ $item->persepsi_e3 }}</td>
                          <td width="5">{{ $item->persepsi_e4 }}</td>
                          <td width="5">{{ $item->persepsi_e5 }}</td>
                          <td width="5">{{ $item->persepsi_rs1 }}</td>
                          <td width="5">{{ $item->persepsi_rs2 }}</td>
                          <td width="5">{{ $item->persepsi_ap1 }}</td>
                          <td width="5">{{ $item->persepsi_ap2 }}</td>
                        </tr>
                        @endforeach
                      
                     </table>

</html>                 