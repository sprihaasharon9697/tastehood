<?php
// Load food data from JSON
$foodData = json_decode(file_get_contents("food_data.json"), true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Diagnosis - TasteHood</title>
</head>
<body>
    <h2>Food Diagnosis</h2>
    
    <form id="diagnosisForm">
        <label for="foodItem">Enter Food Item:</label>
        <input type="text" id="foodItem" placeholder="e.g., Pizza" required>

        <label for="allergy">Select Allergy:</label>
        <select id="allergy">
            <option value="">--Select--</option>
            <?php
            foreach ($foodData["allergens"] as $allergen) {
                echo "<option value='$allergen'>$allergen</option>";
            }
            ?>
        </select>

        <button type="submit">Check</button>
    </form>

    <div id="result"></div>

    <script>
        document.getElementById("diagnosisForm").addEventListener("submit", function (e) {
            e.preventDefault();
            
            let foodItem = document.getElementById("foodItem").value.trim().toLowerCase();
            let selectedAllergy = document.getElementById("allergy").value;
            let foodData = <?php echo json_encode($foodData["foods"]); ?>;
            
            let food = foodData.find(item => item.name.toLowerCase() === foodItem);

            if (!food) {
                document.getElementById("result").innerHTML = "<p style='color:red;'>Food not found in our database.</p>";
                return;
            }

            if (food.contains.includes(selectedAllergy)) {
                document.getElementById("result").innerHTML = `<p style='color:red;'>⚠️ Warning! ${food.name} contains ${selectedAllergy}.</p>
                    <h3>Better Alternatives:</h3><ul>` + food.alternative.map(alt => `<li>${alt}</li>`).join('') + `</ul>`;
            } else {
                document.getElementById("result").innerHTML = `<p style='color:green;'>✅ Safe to eat! ${food.name} does not contain ${selectedAllergy}.</p>`;
            }
        });
    </script>
</body>
</html>
