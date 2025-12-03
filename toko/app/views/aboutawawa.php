14-33
              <?php
              // Calculate totals from provided arrays (if available)
              $totalGudang = 0;
              $totalEtalase = 0;
              if (!empty($stokGudang) && is_array($stokGudang)) {
                 foreach ($stokGudang as $s) {
                    $totalGudang += intval($s['total_stok_gudang'] ?? 0);
                 }
              } elseif (isset($totalGudang)) {
                 $totalGudang = intval($totalGudang);
              }
              if (!empty($stokEtalase) && is_array($stokEtalase)) {
                 foreach ($stokEtalase as $s) {
                    $totalEtalase += intval($s['total_stok_eta'] ?? 0);
                 }
              } elseif (isset($totalEtalase)) {
                 $totalEtalase = intval($totalEtalase);
              }
              $grandTotal = $totalGudang + $totalEtalase;
              ?>
                            <!-- <div class="mt-3">
               <h5>Stok Tersedia</h5>
               <ul>
                 <li>Stok Gudang: <strong><?= htmlspecialchars($totalGudang) ?> pcs</strong></li>
                 <li>Stok Etalase: <strong><?= htmlspecialchars($totalEtalase) ?> pcs</strong></li>
                 <li>Total Stok: <strong><?= htmlspecialchars($grandTotal) ?> pcs</strong></li>
               </ul>
              </div> -->

              <!-- <div class="read_bt_1"><a href="#">Read More</a></div> -->
            </div>