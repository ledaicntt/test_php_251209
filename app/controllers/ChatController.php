<?php
require_once __DIR__ . "/../services/ApiService.php";

class ChatController {

    private function dbg($label, $value) {
        echo "<pre style='background:#222;color:#0f0;padding:10px'>";
        echo "DEBUG: $label\n";
        print_r($value);
        echo "</pre>";
        @ob_flush(); @flush();
    }

    public function handle($message) {
        $api = new ApiService();

        // -------------------------
        // 1) DEBUG INPUT
        // -------------------------
        // $this->dbg("INPUT MESSAGE", $message);

        // -------------------------
        // 2) Normalize
        // -------------------------
        $norm = $api->normalize($message);
        // $this->dbg("NORMALIZE RESULT", $norm);

        $normalized = $norm["normalized"] ?? "";

        // -------------------------
        // 3) Search
        // -------------------------
        $search = $api->search($normalized);
        // $this->dbg("SEARCH CANDIDATES", $search);

        $candidates = $search["candidates"] ?? [];

        // Nếu không có candidate → trả lỗi rõ ràng
        if (count($candidates) === 0) {
            return "Không tìm thấy dịch vụ nào phù hợp. Bạn mô tả rõ hơn được không ạ?";
        }

        // -------------------------
        // 4) AI Service Selector
        // -------------------------
        $select = $api->aiSelect($message, $normalized, $candidates);
        // $this->dbg("AI SELECT RESULT", $select);

        if (!isset($select["services"]) || empty($select["services"])) {
            return "AI chưa xác định được dịch vụ phù hợp. Bạn nói rõ hơn được không ạ?";
        }

        if (!empty($select["needs_clarification"])) {
            return "Bạn vui lòng mô tả chi tiết dịch vụ cần tra cứu hơn nhé.";
        }

        $sid = $select["services"][0];
        // $this->dbg("SELECTED SERVICE ID", $sid);

        // -------------------------
        // 5) AI Answer
        // -------------------------
        $answer = $api->aiAnswer($sid);
        // $this->dbg("AI ANSWER RESULT", $answer);

        return $answer["answer"] ?? "Không tạo được câu trả lời từ AI.";
    }
}
