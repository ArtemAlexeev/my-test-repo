on:
  pull_request_review:
name: Example Job
jobs:
  myJob:
    runs-on: ubuntu-latest
    steps:
      - uses: luisrjaeger/approved-event-checker@master
        id: approved
        with:
          approvals: 2
          check_changes_requested: false
        env:
          GITHUB_TOKEN: ${{ secrets.GITHUB_TOKEN }}
      - run: echo "Approved !!"
        if: ${{ steps.approved.outputs.approved == 'true' }}

      - run: echo "status -- ${{ steps.approved.outputs.approved }}"
        name: echo stage
