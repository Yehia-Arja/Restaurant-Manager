import '../../domain/entities/table_entity.dart';

class TableModel extends TableEntity {
  TableModel({required int id, required String label}) : super(id: id, label: label);

  factory TableModel.fromJson(Map<String, dynamic> json) {
    return TableModel(
      id: json['id'] as int,
      label: json['label'] as String, // adjust key if your API uses “number” or “name”
    );
  }
}
