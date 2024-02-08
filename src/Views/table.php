<?php
define('CSS_PATH', 'assets/');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo CSS_PATH; ?>style.css">
</head>
<body>
    <table id="cells">
        <?php
        for($i = 0; $i < $table->get_rows(); $i++) {
            echo '<tr>';
            for ($j = 0; $j < $table->get_cols(); $j++) {
                $cell_id = 'value ' . $i . ' ' . $j;
                $tag = sprintf("<td id=\"%s\" contenteditable=\"true\" onblur=\"onBlur('%s')\" onfocus=\"onFocus('%s')\">", $cell_id, $cell_id, $cell_id);
                echo $tag . htmlspecialchars($table->get_value($i, $j) ?? '') . '</td>';
            }
            echo '</tr>';
        }
        ?>
    </table>
    <table id="formulas" style="display:none">
        <?php
        for($i = 0; $i < $table->get_rows(); $i++) {
            echo '<tr>';
            for ($j = 0; $j < $table->get_cols(); $j++) {
                $cell_id = 'formula ' . $i . ' ' . $j;
                $tag = sprintf("<td id=\"%s\">", $cell_id);
                echo $tag . htmlspecialchars($table->get_formula($i, $j) ?? '') . '</td>';
            }
            echo '</tr>';
        }
        ?>
    </table>
    <script>
        const ws = new WebSocket('ws://localhost:8080');
        const segments = new URL(window.location.href).pathname.split('/');
        const table_id = segments.pop() || segments.pop(); // Handle potential trailing slash
        console.log(table_id);

        function swapValueAndFormula(row, col) {
            var formula = document.getElementById("formula " + row + " " + col);
            var value = document.getElementById("value " + row + " " + col);
            var tmp = formula.innerText;
            formula.innerText = value.innerText;
            value.innerText = tmp;
        }

        function onFocus(cell_id) {
            const split_cell_id = cell_id.split(" ");
            const row = split_cell_id[1];
            const col = split_cell_id[2];
            ws.send(JSON.stringify({
                event_type: "lock",
                table_id: table_id,
                row: row,
                col: col,
            }));

            swapValueAndFormula(row, col);
        }

        function onBlur(cell_id) {
            const split_cell_id = cell_id.split(" ");
            const row = split_cell_id[1];
            const col = split_cell_id[2];
            ws.send(JSON.stringify({
                event_type: "unlock",
                table_id: table_id,
                row: row,
                col: col,
            }));

            swapValueAndFormula(row, col);
        }

        ws.onopen = function() {
            console.log('Connected to WebSocket server');
        };

        ws.onerror = function(error) {
            console.error('WebSocket error:', error);
        };

        ws.onmessage = function(event) {
            const data = JSON.parse(event.data);
            console.log('received_msg');
        };
    </script>
</body>
</html>