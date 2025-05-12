import 'package:bloc/bloc.dart';

// Holds the currently selected branch ID
class SelectedBranchCubit extends Cubit<int?> {
  SelectedBranchCubit() : super(null);

  // Call this when a branch is tapped
  void select(int id) => emit(id);
}
