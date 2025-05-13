import 'package:bloc/bloc.dart';

class SelectedRestaurantCubit extends Cubit<int?> {
  SelectedRestaurantCubit() : super(null);

  // Call this when a restaurant is tapped
  void select(int id) => emit(id);
}
