import 'package:flutter/material.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter_bloc/flutter_bloc.dart';

import 'package:mobile/core/blocs/selected_branch_cubit.dart';
import 'package:mobile/features/home/domain/entities/branch.dart';

class BranchSelector extends StatefulWidget {
  final List<Branch> branches;
  final VoidCallback? onNotificationTap;

  const BranchSelector({Key? key, required this.branches, this.onNotificationTap})
    : super(key: key);

  @override
  State<BranchSelector> createState() => _BranchSelectorState();
}

class _BranchSelectorState extends State<BranchSelector> {
  bool _menuOpen = false;

  @override
  Widget build(BuildContext context) {
    final selectedId = context.watch<SelectedBranchCubit>().state;
    final matches = widget.branches.where((b) => b.id == selectedId);
    final current = matches.isNotEmpty ? matches.first : widget.branches.first;

    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 20),
      child: Row(
        children: [
          PopupMenuButton<Branch>(
            tooltip: 'Select Branch',
            offset: const Offset(0, 48),
            shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(6)),
            color: Colors.white,
            onOpened: () => setState(() => _menuOpen = true),
            onCanceled: () => setState(() => _menuOpen = false),
            onSelected: (b) {
              context.read<SelectedBranchCubit>().select(b.id);
              setState(() => _menuOpen = false);
            },
            itemBuilder:
                (_) =>
                    widget.branches
                        .map((b) => PopupMenuItem<Branch>(value: b, child: Text(b.locationName)))
                        .toList(),
            child: Padding(
              padding: const EdgeInsets.symmetric(vertical: 8),
              child: Row(
                mainAxisSize: MainAxisSize.min,
                children: [
                  const Icon(Icons.location_on_outlined, color: Colors.white, size: 20),
                  const SizedBox(width: 8),
                  Flexible(
                    child: Text(
                      current.locationName,
                      style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                        color: Colors.white,
                        fontWeight: FontWeight.w600,
                      ),
                      overflow: TextOverflow.ellipsis,
                      maxLines: 1,
                    ),
                  ),
                  const SizedBox(width: 4),
                  Icon(
                    _menuOpen ? CupertinoIcons.chevron_up : CupertinoIcons.chevron_down,
                    color: Colors.white,
                    size: 16,
                  ),
                ],
              ),
            ),
          ),
          const Spacer(),
          IconButton(
            icon: const Icon(Icons.person),
            color: Colors.white,
            onPressed: widget.onNotificationTap,
          ),
        ],
      ),
    );
  }
}
