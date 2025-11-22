# TODO: Integrate Total Kamar in Dashboard Pemilik Kos

## Step 1: Create Migration for jumlah_kamar_total
- Create a new migration file to add 'jumlah_kamar_total' column to kos table.

## Step 2: Update Kos Model
- Add 'jumlah_kamar_total' to the fillable array in app/Models/Kos.php.

## Step 3: Update KostController
- Add validation for 'jumlah_kamar_total' in store and update methods.
- Ensure the field is handled in create and edit forms.

## Step 4: Update Views
- Update resources/views/kost/create.blade.php to include input for jumlah_kamar_total.
- Update resources/views/kost/edit.blade.php to include input for jumlah_kamar_total.
- Update resources/views/kost/index.blade.php to display jumlah_kamar_total.
- Update resources/views/home.blade.php to correctly calculate and display total kamar.

## Step 5: Update Routes
- Modify routes/web.php to calculate $totalKamar as sum of 'jumlah_kamar_total' instead of 'jumlah_kamar_kosong'.

## Step 6: Run Migration
- Execute the migration to add the new column to the database.

## Step 7: Test and Verify
- Test the application to ensure total kamar is correctly displayed on the dashboard.
- Verify that create, edit, and index pages handle the new field properly.
