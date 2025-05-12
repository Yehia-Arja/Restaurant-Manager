import '../../domain/entities/table_entity.dart';

class TableModel extends TableEntity {
  TableModel({required int id, required bool isOccupied, required int floor})
    : super(id: id, isOccupied: isOccupied, floor: floor);

  factory TableModel.fromJson(Map<String, dynamic> json) {
    return TableModel(
      id: json['id'] as int,
      isOccupied: (json['status'] as String).toLowerCase() == 'occupied',
      floor: json['floor'] as int,
    );
  }
}
